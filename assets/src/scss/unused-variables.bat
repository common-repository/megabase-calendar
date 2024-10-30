VAR_NAME_CHARS='A-Za-z0-9_-'
find "$1" -type f -name "*.scss" -exec grep -o "\$[$VAR_NAME_CHARS]*" {} ';' | sort | uniq -u