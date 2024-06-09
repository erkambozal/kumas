<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ödeme Alınamadı</title>
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-color: #f0f0f0;
    }
    
    .error-message {
      text-align: center;
    }
    
    .cross-mark {
      font-size: 100px;
      color: red;
    }
  </style>
</head>
<body>
  <div class="error-message">
    <span class="cross-mark">&#10060;</span>
    <h1>Ödeme Alınamadı</h1>
	  <h2>Tekrar Deneyiniz.</h2>
  </div>
	<a href="/checkout" id="myLink"></a>

<script>
     window.onload = function() {
        setTimeout(function() {
            document.getElementById('myLink').style.display = 'inline'; // Bağlantıyı görünür yap
            document.getElementById('myLink').click(); // Bağlantıya tıklama işlemi
        }, 3000); // 3 saniye bekleyerek tıklama işlemini gerçekleştir
    }
</script>
<style>
	#myLink {
    display: none;
}
	</style>
</body>
</html>