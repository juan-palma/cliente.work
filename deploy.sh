#!/bin/bash
# PLANTILLA: copiala a la raiz de tu proyecto local como ./deploy.sh y ajusta las 3 variables.
#   ./deploy.sh              avisa si falta commit/push y luego ejecuta `desplegar <sitio>` en el servidor
#   ./deploy.sh --ver        solo muestra que cambiaria
#   ./deploy.sh --atras      vuelve al despliegue anterior
#   ./deploy.sh --archivos   sube SOLO los archivos que no van en git (los de SOLO_SERVIDOR); agrega --aplicar para hacerlo
set -euo pipefail
SITIO="cliente.work"                                                   # nombre en /opt/scripts/sitios-git.list
DESTINO="/opt/sites/vhosts/idalibre.com/cliente.work"     # carpeta publica del sitio en el servidor
SOLO_SERVIDOR=()                                                # ej: (.env config/produccion.php)  rutas relativas al proyecto
ALIAS="vps1-deploy"

if [ "${1:-}" = "--archivos" ]; then
  [ ${#SOLO_SERVIDOR[@]} -gt 0 ] || { echo "No hay archivos en SOLO_SERVIDOR."; exit 0; }
  OPC=(-avzR --itemize-changes); [ "${2:-}" = "--aplicar" ] || { OPC+=(--dry-run); echo "(simulacion; agrega --aplicar para subir)"; }
  rsync "${OPC[@]}" "${SOLO_SERVIDOR[@]}" "$ALIAS:$DESTINO/"
  exit 0
fi

if git rev-parse --git-dir >/dev/null 2>&1; then
  [ -z "$(git status --porcelain)" ] || echo "AVISO: tienes cambios sin commit (no se despliegan)."
  git fetch -q 2>/dev/null || true
  [ -z "$(git log @{u}.. --oneline 2>/dev/null)" ] || echo "AVISO: hay commits sin push (no se despliegan)."
fi
ssh "$ALIAS" desplegar "$SITIO" "$@"
