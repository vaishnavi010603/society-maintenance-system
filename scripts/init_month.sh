#!/bin/bash

MONTH=$1

if [ -z "$MONTH" ]; then
    echo "Usage: ./init_month.sh March-2026"
    exit 1
fi

OUTPUT="../data/payments/payments_${MONTH}.csv"

echo "FlatNo,Month,Paid" > $OUTPUT

tail -n +2 ../data/members.csv | while IFS=',' read flat name
do
    echo "$flat,$MONTH,No" >> $OUTPUT
done

echo "Month $MONTH initialized successfully."
