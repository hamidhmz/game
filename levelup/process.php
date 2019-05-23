<?php
    $sqlp1 = "SELECT * FROM tmpuser WHERE username=:username";
    $resultp1 = $connect -> prepare($sqlp1);
    $resultp1 -> bindvalue(":username",$Player);
    $resultp1 -> execute();
    $fetchp1 = $resultp1 -> fetch(PDO::FETCH_ASSOC);
    $rake = $fetchp1['rake'];

    if ($rake<5000) {
        $level = 1;
    }
    elseif ($rake<15000 && $rake>=5000) {
        $level = 2;
    }
    elseif ($rake<25000 && $rake>=15000) {
        $level = 3;
    }
    elseif ($rake<50000 && $rake>=25000) {
        $level = 4;
    }
    elseif ($rake<100000 && $rake>=50000) {
        $level = 5;
    }
    elseif ($rake<150000 && $rake>=100000) {
        $level = 6;
    }
    elseif ($rake<200000 && $rake>=150000) {
        $level = 7;
    }
    elseif ($rake<300000 && $rake>=200000) {
        $level = 8;
    }
    elseif ($rake<450000 && $rake>=300000) {
        $level = 9;
    }
    elseif ($rake<700000 && $rake>=450000) {
        $level = 10;
    }
    elseif ($rake<1000000 && $rake>=700000) {
        $level = 11;
    }
    elseif ($rake<1300000 && $rake>=1000000) {
        $level = 12;
    }
    elseif ($rake<1800000 && $rake>=1300000) {
        $level = 13;
    }
    elseif ($rake<2500000 && $rake>=1800000) {
        $level = 14;
    }
    elseif ($rake<3500000 && $rake>=2500000) {
        $level = 15;
    }
    elseif ($rake<5000000 && $rake>=3500000) {
        $level = 16;
    }
    elseif ($rake<7000000 && $rake>=5000000) {
        $level = 17;
    }
    elseif ($rake<9000000 && $rake>=7000000) {
        $level = 18;
    }
    elseif ($rake<12000000 && $rake>=9000000) {
        $level = 19;
    }
    elseif ($rake<15000000 && $rake>=12000000) {
        $level = 20;
    }
    elseif ($rake<18000000 && $rake>=15000000) {
        $level = 21;
    }
    elseif ($rake<22000000 && $rake>=18000000) {
        $level = 22;
    }
    elseif ($rake<26000000 && $rake>=22000000) {
        $level = 23;
    }
    elseif ($rake<31000000 && $rake>=26000000) {
        $level = 24;
    }
    elseif ($rake<36000000 && $rake>=31000000) {
        $level = 25;
    }
    elseif ($rake<41000000 && $rake>=36000000) {
        $level = 26;
    }
    elseif ($rake<45000000 && $rake>=41000000) {
        $level = 27;
    }
    elseif ($rake<50000000 && $rake>=45000000) {
        $level = 28;
    }
    elseif ($rake<60000000 && $rake>=50000000) {
        $level = 29;
    }
    elseif ($rake>=60000000) {
        $level = 30;
    }
?>