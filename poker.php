<?php

    class Poker_Hand {
        private $card = [];
        private $judge;
    
        public function __construct($suit1, $number1, $suit2, $number2, $suit3, $number3, $suit4, $number4, $suit5, $number5) {
            $this->card = [
                ['suit' => strtolower($suit1), 'number' => (int)$number1],
                ['suit' => strtolower($suit2), 'number' => (int)$number2],
                ['suit' => strtolower($suit3), 'number' => (int)$number3],
                ['suit' => strtolower($suit4), 'number' => (int)$number4],
                ['suit' => strtolower($suit5), 'number' => (int)$number5]
            ];
        }
    
        public function getPokerHandJudge() {
            return $this->judge;
        }
    
        public function getCard() {
            return $this->card;
        }
    
        public function setPokerHandJudge() {
            $sorted = $this->cardSort($this->card);
    
            if (!$this->fraudJudge($sorted)) {
                $this->judge = "不正なカードの組み合わせです";
                return;
            }
    
            $numbers = array_column($sorted, 'number');
            $suits = array_column($sorted, 'suit');
    
            $counts = array_count_values($numbers);
            $isFlush = count(array_unique($suits)) === 1;
            $isStraight = $this->isStraight($numbers);
    
            if ($isFlush && $isStraight && max($numbers) === 13 && min($numbers) === 9) {
                $this->judge = "ロイヤルストレートフラッシュ";
            } elseif ($isFlush && $isStraight) {
                $this->judge = "ストレートフラッシュ";
            } elseif (in_array(4, $counts)) {
                $this->judge = "フォーカード";
            } elseif (in_array(3, $counts) && in_array(2, $counts)) {
                $this->judge = "フルハウス";
            } elseif ($isFlush) {
                $this->judge = "フラッシュ";
            } elseif ($isStraight) {
                $this->judge = "ストレート";
            } elseif (in_array(3, $counts)) {
                $this->judge = "スリーカード";
            } elseif (array_keys($counts, 2) !== null && count(array_keys($counts, 2)) === 2) {
                $this->judge = "ツーペア";
            } elseif (in_array(2, $counts)) {
                $this->judge = "ワンペア";
            } else {
                $this->judge = "ノーペア";
            }
        }
    
        private function cardSort($hand) {
            usort($hand, function($a, $b) {
                return $a['number'] - $b['number'];
            });
            return $hand;
        }
    
        private function fraudJudge($hand) {
            $seen = [];
            foreach ($hand as $card) {
                $key = $card['suit'] . '-' . $card['number'];
                if (in_array($key, $seen)) return false;
                $seen[] = $key;
            }
            return true;
        }
    
        private function isStraight($numbers) {
            sort($numbers);
            // A,2,3,4,5 の特例（1を14と考えたAハイはロイヤルで別処理済み）
            if ($numbers === [1, 2, 3, 4, 5]) return true;
    
            for ($i = 0; $i < 4; $i++) {
                if ($numbers[$i + 1] - $numbers[$i] !== 1) return false;
            }
            return true;
        }
    }
?>
    
