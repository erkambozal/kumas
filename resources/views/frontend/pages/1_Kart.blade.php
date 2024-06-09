<form action="{{ route('pay') }}" method='post'>
	@csrf
		Card Holder Name: <input name="CardHolderName" type="text" value="" />
		<br />
		Card Number: <input name="CardNumber" type="text" value="" />
		<br />
		Expire Date (mm): <input name="CardExpireDateMonth"  type="text" value="" />
		<br />
		Expire Date (yy): <input name="CardExpireDateYear" type="text" value=""  />
		<br />
		CVV2: <input name="CardCVV2" type="text" value="" />
		<br />
		Tutar: <input name="Amount" type="text" value="" />
		<br />	
		  <input id="submit" type="submit" value="G�nder" />
	</form>
	
	