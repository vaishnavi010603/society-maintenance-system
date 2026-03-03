#!/bin/bash

MONTH=$1
FLAT=$2

FILE="../data/payments/payments_${MONTH}.csv"

if [ ! -f "$FILE" ]; then
    echo "Month not initialized!"
    exit 1
fi

sed -i "s/^$FLAT,$MONTH,No/$FLAT,$MONTH,Yes/" $FILE

echo "Flat $FLAT marked as paid for $MONTH."
