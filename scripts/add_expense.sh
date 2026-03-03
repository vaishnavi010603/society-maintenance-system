#!/bin/bash

DESC="$1"
AMOUNT="$2"
DATE=$(date +%d-%m-%Y)

if [ -z "$DESC" ] || [ -z "$AMOUNT" ]; then
    echo "Usage: ./add_expense.sh \"Description\" Amount"
    exit 1
fi

echo "$DATE,$DESC,$AMOUNT" >> ../data/expenses.csv

echo "Expense added successfully."
