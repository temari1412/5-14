
<?php
require_once 'poker.php';

$pokerHand = null;
$handJudge = "";
$cards = [];

// POST送信を受けてPoker_Handを生成・判定
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $suits = [];
    $numbers = [];
    for ($i = 1; $i <= 5; $i++) {
        $suits[$i] = $_POST["suit$i"] ?? "";
        $numbers[$i] = $_POST["number$i"] ?? "";
    }

    $pokerHand = new Poker_Hand(
        $suits[1], $numbers[1],
        $suits[2], $numbers[2],
        $suits[3], $numbers[3],
        $suits[4], $numbers[4],
        $suits[5], $numbers[5]
    );

    $pokerHand->setPokerHandJudge();
    $handJudge = $pokerHand->getPokerHandJudge();
    $cards = $pokerHand->getCard();
}
?>

<!DOCTYPE html>
<html data-wf-page="65a6358f98ae25d9e60af7b3" data-wf-site="65a6257c9b4dab4f4c5b2ebc">
<head>
  <meta charset="utf-8">
  <title>Pocker Program</title>
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <meta content="Webflow" name="generator">
  <link href="css/normalize.css" rel="stylesheet" type="text/css">
  <link href="css/stylesheet.css" rel="stylesheet" type="text/css">
  <link href="css/poker-game-sample.css" rel="stylesheet" type="text/css">
  <link href="images/spade/1.png" rel="shortcut icon" type="image/x-icon">
</head>
<body>
  <div class="w-form">
    <form id="email-form" action="index.php" name="email-form" data-name="Email Form" method="post" class="form-2" data-wf-page-id="65a6358f98ae25d9e60af7b3" data-wf-element-id="86774d01-babd-216e-a0af-c3f43d9ae051">
      <div class="w-layout-blockcontainer container-2 w-container">
        <?php for ($i = 1; $i <= 5; $i++): ?>
          <div class="w-layout-blockcontainer card-container w-container">
          <label for="" class="field-label<?= $i > 1 ? '-' . $i : '' ?>">CARD <?= $i ?></label>
          <div class="w-layout-blockcontainer container w-container">
            <select id="suit<?= $i ?>" name="suit<?= $i ?>" class="suit-<?= $i ?> w-select">
              <option value=""></option>
              <?php foreach(['spade','heart','diamond','club'] as $suit): ?>
                <option value="<?= $suit ?>" <?= (isset($cards[$i-1]['suit']) && $cards[$i-1]['suit'] === $suit) ? 'selected' : '' ?>><?= $suit ?></option>
              <?php endforeach; ?>
            </select>
            <select id="number<?= $i ?>" name="number<?= $i ?>" class="number<?= $i ?> w-select">
              <option value=""></option>
              <?php for ($num = 1; $num <= 13; $num++): ?>
                <option value="<?= $num ?>" <?= (isset($cards[$i-1]['number']) && (int)$cards[$i-1]['number'] === $num) ? 'selected' : '' ?>><?= $num ?></option>
              <?php endfor; ?>
            </select>
          </div>
        </div>
        <?php endfor; ?>
      </div>
      <button type="submit" class="button w-button">SEND</button>
    </form>
    <div class="w-form-done">
      <div>Thank you! Your submission has been received!</div>
    </div>
    <div class="w-form-fail">
      <div>Oops! Something went wrong while submitting the form.</div>
    </div>
  </div>

  <section>
    <h1 class="heading-2">hand of cards：</h1>
    <div class="w-layout-grid grid">
      <?php if ($pokerHand): ?>
        <?php foreach ($cards as $c): ?>
          <?php if ($c['suit'] && $c['number']): ?>
            <img src="images/<?= htmlspecialchars($c['suit']) ?>/<?= htmlspecialchars($c['number']) ?>.png" loading="lazy" alt="<?= htmlspecialchars($c['suit']) ?> <?= htmlspecialchars($c['number']) ?>" />
          <?php endif; ?>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- デフォルト画像を表示 -->
        <img src="images/spade/1.png" loading="lazy" alt="spade 1" />
        <img src="images/spade/2.png" loading="lazy" alt="spade 2" />
        <img src="images/spade/3.png" loading="lazy" alt="spade 3" />
        <img src="images/spade/4.png" loading="lazy" alt="spade 4" />
        <img src="images/spade/5.png" loading="lazy" alt="spade 5" />
      <?php endif; ?>
    </div>
  </section>

  <h1 class="heading-3"><strong>A poker hand→</strong>
    <?= $handJudge ? htmlspecialchars($handJudge) : "役がここに表示されます" ?>
  </h1>
</body>
</html>

