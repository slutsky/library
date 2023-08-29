LOG_FOLDER="/app/var/log"
ACCESS_LOG="nginx_access.log"
ERROR_LOG="nginx_error.log"

ACCESS_LOG_PATH="${LOG_FOLDER}/${ACCESS_LOG}"
ERROR_LOG_PATH="${LOG_FOLDER}/${ERROR_LOG}"

if [[ ! -d "${LOG_FOLDER}" ]]; then
    mkdir -p "${LOG_FOLDER}"

    if [[ ! -f "${ACCESS_LOG_PATH}" ]]; then
        touch "${ACCESS_LOG_PATH}"
    fi

    if [[ ! -f "${ERROR_LOG_PATH}" ]]; then
        touch "${ERROR_LOG_PATH}"
    fi
fi
