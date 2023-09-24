<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $sql = "
        CREATE PROCEDURE `processTransaction2`(
            IN `userSelect` INT, 
            IN `amount` DECIMAL(10,2), 
            IN `tax_value` DECIMAL(5,2)
        )
        BEGIN
        DECLARE
        balance_before DECIMAL(10, 2) ; DECLARE balance_after DECIMAL(10, 2) ; DECLARE amount_before DECIMAL(10, 2) ; DECLARE amount_after DECIMAL(10, 2) ; DECLARE userwallet_balance DECIMAL(10, 2) ; DECLARE wallet_balance DECIMAL(10, 2) ;
        -- Fetch user and client wallet data
    SELECT
        balance
    INTO userwallet_balance
FROM
    users u1
JOIN wallets w1 ON
    u1.id = w1.user_id
WHERE
    u1.role = 1
LIMIT 1 ;
SELECT
    balance
INTO wallet_balance
FROM
    users u2
JOIN wallets w2 ON
    u2.id = w2.user_id
WHERE
    u2.id = userSelect
LIMIT 1 ;
-- Calculate values
SET
    balance_before = wallet_balance ;
SET
    amount_before = amount ;
SET
    amount_after = amount -(amount * tax_value / 100) ;
SET
    balance_after = wallet_balance + amount_after ;
    -- Update user wallet
UPDATE
    wallets
SET
    balance = userwallet_balance - amount_after
WHERE
    user_id =(
    SELECT
        id
    FROM
        users
    WHERE
        role = 1
    LIMIT 1
) ;
-- Update client wallet
UPDATE
    wallets
SET
    balance = balance_after
WHERE
    user_id = userSelect ;
    -- Insert transaction record
INSERT INTO processes(
    wallet_id,
    balance_before,
    balance_after,
    amount_before,
    amount_after,
    tax_value,
    created_at
)
VALUES(
    userSelect,
    balance_before,
    balance_after,
    amount_before,
    amount_after,
    tax_value,
    now()
) ;
        END;
        ";
        DB::unprepared($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         // You can drop the stored procedure in the down method if needed
         $sql = "DROP PROCEDURE IF EXISTS `processTransaction`";
         DB::unprepared($sql);
    }
};
