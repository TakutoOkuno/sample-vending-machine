<?php

declare(strict_types=1);

/**
 * メインクラス。
 * 原則ここにロジックは書かないこと。
 */
class Main
{
    public const MENUS = [
        'cola' => ['price' => 120],
        'coffee' => ['price' => 150],
        'energy_drink' => ['price' => 210],
    ];

    private const MONEY = [
        10000, 5000, 2000, 1000, 500, 100, 50, 10, 5, 1
    ];

    /**
     * 処理の開始地点
     *
     * @param array $coins 投入額
     * @param string $menu 注文
     * @return string おつり。大きな硬貨順に枚数を並べる。なしの場合はnochange
     * ex.)
     * - 100円3枚、50円1枚、10円3枚なら"100 3 50 1 10 3"
     */
    public static function runSimply(array $coins, string $menu): string
    {
        $amountOfMoney = self::calculateAmountOfMoney($coins);
        $price = self::MENUS[$menu]['price'];

        if ($amountOfMoney === $price) {
            return 'nochange';
        }
        // 本来なら適当な処理や返却文言を考える必要あり
        if (!self::canBuy($amountOfMoney, $price)) {
            return '買えませんでした';
        }

        $amountOfChange = $amountOfMoney - $price;

        return self::convertChangeDictionaryIntoString(self::getChangeDictionary($amountOfChange));
    }

    /**
     * 処理の開始地点。ただし自動販売機がいくつ硬貨を持っているかも合わせて処理する
     *
     * @param array $vendingMachineCoins 自販機に補充される硬貨
     * @param array $userInput 投入額と注文。前述の$coinsと$menuをあわせたもの
     * @return string おつり。大きな硬貨順に枚数を並べる。なしの場合はnochange
     * ex.)
     * - 100円3枚、50円1枚、10円3枚なら"100 3 50 1 10 3"
     */
    public static function run(array $vendingMachineCoins, array $userInput): string
    {
        return "do implementation";
    }

    private static function calculateAmountOfMoney(array $coins): int
    {
        $amountOfMoney = 0;
        foreach ($coins as $key => $value) {
            $amountOfMoney += $key * $value;
        }
        return $amountOfMoney;
    }

    private static function canBuy(int $amountOfMoney, int $price): bool
    {
        return $amountOfMoney >= $price;
    }

    private static function getChangeDictionary(int $amountOfChange): array
    {
        $changes = [];
        foreach (self::MONEY as $money) {
            if ($amountOfChange < $money) continue;
            $changes += [$money => 0];

            do {
                $amountOfChange = $amountOfChange - $money;
                $changes[$money]++;
            } while ($amountOfChange - $money >= 0);
        }

        return $changes;
    }

    private static function convertChangeDictionaryIntoString($changes): string
    {
        $changeString = "";
        foreach ($changes as $money => $amount) {
            $changeString .= "$money $amount" . " ";
        }
        return substr($changeString, 0, -1);
    }
}
