<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ödeme Alındı</title>
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-color: #f0f0f0;
    }
    
    .success-message {
      text-align: center;
    }
    
    .tick-mark {
      font-size: 100px;
      color: green;
    }
  </style>
</head>
<body>
  <div class="success-message">
    <span class="tick-mark">&#10004;</span>
    <h1>Ödemeniz Alındı</h1>
	 <h2> Siparişinizi en kısa sürede teslim edeceğiz. Bizi tercih ettiğiniz için teşekkür ederiz.</h2>
	  <h3> Whatsapp üzerinden bize ulaşabilirsiniz. </h3>
  </div>
	<a href="/" id="myLink"></a>

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