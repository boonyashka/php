# Define the output file
OUTPUT_FILE="tests/test_output.log"
FILTERED_OUTPUT_FILE="tests/test_output_filtered.log"

# Run the command and capture its output

echo "Running tests..."
php artisan migrate:refresh --seed -q
php artisan test > "$OUTPUT_FILE" 2>&1


grep -e '  ⨯' -e '  ✓' "$OUTPUT_FILE" > "$FILTERED_OUTPUT_FILE" 2>&1

mv "$FILTERED_OUTPUT_FILE" "$OUTPUT_FILE"

if [ $(grep -c "⨯" $OUTPUT_FILE) -eq 0 ]
then
    ERROR_CODE=0
else
    ERROR_CODE=1
fi

if [ $ERROR_CODE -eq 0 ]; then
  echo "Tests passed"
else
  echo "Tests failed"
fi

cat "$OUTPUT_FILE"
exit $ERROR_CODE