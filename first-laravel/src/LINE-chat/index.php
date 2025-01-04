<?php
header('Content-Type: text/html; charset=UTF-8');

// データベース接続
$dsn = 'sqlsrv:server=WEBPC3;database=TOSCOM';
$user = "sa";
$password = "toscom";

try {
  $db = new PDO($dsn, $user, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("データベース接続エラー: " . $e->getMessage());
}

// 検索条件の取得
$customerType = $_POST['customer-type'] ?? null;
$region = $_POST['region'] ?? null;
$customerName = $_POST['customer-name'] ?? null;

// SQLクエリの生成
$sqlSearch = "
    SELECT 顧客.顧客名, 顧客.企業CD, 顧客.店舗CD, 顧客.電話番号
    FROM dbo.MST_顧客 AS 顧客
    INNER JOIN dbo.MST_都道府県 AS 都道府県 ON 顧客.地域区分 = 都道府県.都道府県NO
    WHERE 1=1
";

$params = [];
if (!empty($customerType)) {
  $sqlSearch .= " AND 顧客.顧客区分 = :customerType";
  $params[':customerType'] = $customerType;
}
if (!empty($region)) {
  $sqlSearch .= " AND 都道府県.都道府県NO = :region";
  $params[':region'] = $region;
}
if (!empty($customerName)) {
  $sqlSearch .= " AND 顧客.顧客名 LIKE :customerName";
  $params[':customerName'] = '%' . $customerName . '%';
}

// データベース検索
try {
  $stmt = $db->prepare($sqlSearch);
  foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
  }
  $stmt->execute();
  $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("検索エラー: " . $e->getMessage());
}

// 結果をHTMLとして出力
if (!empty($searchResults)) {
  foreach ($searchResults as $result) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($result['顧客名']) . '</td>';
    echo '<td>' . htmlspecialchars($result['企業CD']) . '</td>';
    echo '<td>' . htmlspecialchars($result['店舗CD']) . '</td>';
    echo '</tr>';
  }
} else {
  echo '<tr><td colspan="3">検索結果がありません</td></tr>';
}
?>




<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/reset.css" rel="stylesheet">
  <title>顧客情報フォーム</title>
</head>

<body>
  <div class="container">
    <h2>顧客情報フォーム</h2>
    <!-- フォーム -->
    <form method="POST" action="test02.php" id="customerForm">
      <!-- 顧客区分 -->
      <div class="form-group">
        <label for="customer-type">顧客区分</label>
        <select id="customer-type" name="customer-type">
          <?php if (!empty($customerTypes)) : ?>
            <?php foreach ($customerTypes as $type) : ?>
              <option value="<?= htmlspecialchars($type['顧客区分番号']) ?>">
                <?= htmlspecialchars($type['顧客区分名称']) ?>
              </option>
            <?php endforeach; ?>
          <?php else : ?>
            <option value="">データなし</option>
          <?php endif; ?>
        </select>
      </div>

      <!-- 地域区分 -->
      <div class="form-group">
        <label for="region">地域区分（都道府県）</label>
        <select id="region" name="region">
          <?php if (!empty($prefectures)) : ?>
            <?php foreach ($prefectures as $pref) : ?>
              <option value="<?= htmlspecialchars($pref['都道府県NO']) ?>">
                <?= htmlspecialchars($pref['都道府県']) ?>
              </option>
            <?php endforeach; ?>
          <?php else : ?>
            <option value="">データなし</option>
          <?php endif; ?>
        </select>
      </div>

      <!-- 顧客情報 -->
      <div class="form-group">
        <label for="customer-name">顧客名</label>
        <input type="text" id="customer-name" name="customer-name">
      </div>
      <div class="form-group">
        <label for="kana">カナ</label>
        <input type="text" id="kana" name="kana">
      </div>

      <!-- 電話番号と店舗CD -->
      <div class="form-row">
        <div class="form-group half-width">
          <label for="tel">TEL</label>
          <input type="tel" id="tel" name="tel">
        </div>
        <div class="form-group half-width">
          <label for="store-code">店舗CD</label>
          <input type="text" id="store-code" name="store-code">
        </div>
      </div>

      <!-- 企業CD -->
      <div class="form-group">
        <label for="company-code">企業CD</label>
        <input type="text" id="company-code" name="company-code">
      </div>

      <!-- 表示ボタン -->
      <button type="button" onclick="performSearch()">表示</button>
    </form>

    <!-- 検索結果ポップアップ -->
    <div id="popup" class="popup" style="display: none;">
      <div class="popup-content">
        <span class="close-btn" onclick="closePopup()">&times;</span>
        <h2>検索結果</h2>
        <table>
          <thead>
            <tr>
              <th>顧客名</th>
              <th>企業CD</th>
              <th>店舗CD</th>
            </tr>
          </thead>
          <tbody id="popup-results">
            <!-- PHPで生成された検索結果 -->
            <?php if (!empty($searchResults)): ?>
              <?php foreach ($searchResults as $result): ?>
                <tr>
                  <td><?= htmlspecialchars($result['顧客名']) ?></td>
                  <td><?= htmlspecialchars($result['企業CD']) ?></td>
                  <td><?= htmlspecialchars($result['店舗CD']) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="3">検索結果がありません</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- JavaScript -->
  <script>
    // 非同期検索処理
    function performSearch() {
      const form = document.getElementById('customerForm');
      const formData = new FormData(form);

      fetch('test02.php', {
          method: 'POST',
          body: formData,
        })
        .then(response => response.text())
        .then(data => {
          document.getElementById('popup-results').innerHTML = data;
          document.getElementById('popup').style.display = 'block';
        })
        .catch(error => console.error('検索エラー:', error));
    }

    // ポップアップを閉じる
    function closePopup() {
      document.getElementById('popup').style.display = 'none';
    }
  </script>
</body>

</html>