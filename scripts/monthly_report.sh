#!/bin/bash

MONTH=$1
FILE="../data/payments/payments_${MONTH}.csv"

if [ ! -f "$FILE" ]; then
    echo "Month not initialized!"
    exit 1
fi

TOTAL_MEMBERS=$(($(wc -l < ../data/members.csv) - 1))
EXPECTED=$((TOTAL_MEMBERS * 1000))

COLLECTED_COUNT=$(grep ",Yes" $FILE | wc -l)
COLLECTED=$((COLLECTED_COUNT * 1000))

EXPENSE_TOTAL=$(awk -F',' '{sum+=$3} END {print sum}' ../data/expenses.csv)

if [ -z "$EXPENSE_TOTAL" ]; then
    EXPENSE_TOTAL=0
fi

BALANCE=$((COLLECTED - EXPENSE_TOTAL))

echo "======================================"
echo "        SOCIETY MONTHLY REPORT        "
echo "======================================"
echo "Month: $MONTH"
echo
echo "Total Members        : $TOTAL_MEMBERS"
echo "Expected Collection  : ₹$EXPECTED"
echo "Collected Amount     : ₹$COLLECTED"
echo "Total Expenses       : ₹$EXPENSE_TOTAL"
echo "--------------------------------------"
echo "Remaining Balance    : ₹$BALANCE"
echo
echo "Unpaid Flats:"
grep ",No" $FILE | cut -d',' -f1
echo "======================================"
