<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Receita</title>
</head>
</html>
<?php
	function mostrarForm() {
	echo '<html>

	<form id="formulario" method="POST" action="receita.php">
		<label><h3>Dados de Receita</h3></label><br>
	    
	    <input type="hidden" name="idreceita" id="idreceita" /><br>
		
		<label>Descrição</label><br>
		<input type="text" name="descricao" id="descricao" size=80 /> <br>
		
		<label>Data de Pagamento</label><br>
		<input type="date" name="datapagamento" id="datapagamento" /> <br>

		<label>Valor</label><br>
		<input type="text" name="valor" id="valor" size=30 /> <br><br>
		
		<input type="submit" name="submit"/>
	</form>
	<br>
	</html>';
		}

///////////CONEXÃO COM BANCO///////////////////////
	 $server = "localhost";
	 $usuario = "root";
	 $pass = "";
	 $banco = "studiomaisvoce";
	 
	 $conexao = mysql_connect($server, $usuario, $pass, $banco) or die (mysql_error());
	 mysql_select_db($banco) or die(mysql_error());	
		
		
		//MOSTRA FORM HTML
		mostrarForm();		
	
		/////////////INSERE////////////// 		
		 if (isset($_POST['submit'])&&($_POST['descricao'])){			
		$idreceita=$_POST['idreceita'];	
		$descricao=$_POST['descricao'];
		$datapagamento=$_POST['datapagamento'];
		$valor=$_POST['valor'];	
		
		
		$sql=mysql_query("INSERT INTO receita (Ds_receita, Dt_Pagamento, Vl_Receita)VALUES('$descricao', '$datapagamento', '$valor')");
		
		mostrarTabela();
		}
		/*
		else {
			echo '<script>alert("Prencha campo Descrição");</script>';
		}	
		*/
		function mostrarTabela(){			
		
		$sql=mysql_query("SELECT * FROM receita");
		$myData=$sql; 
		echo "<table border = 1>
		<tr>
		<th>Nº Receita</th>
		<th>Descrição</th>
		<th>Data de pagamento</th>
		<th>Valor</th>
		</tr>";
	
			while($record = mysql_fetch_array($myData)){
			echo "<form action=receita.php method=post>";
			echo "<tr>";
			echo "<td>" . $record['Id_receita'] . "</td>";
			echo "<td>" . $record['Ds_receita'] . " </td>";	
			echo "<td>" . $record['Dt_Pagamento'] . " </td>";
			echo "<td>" . $record['Vl_Receita'] . " </td>";
			echo "<td>" . "<input type=hidden name=hidden value=" . $record['Id_receita'] . "</td>";
			echo "<td>" . "<input type=submit name=alterar1 value=alterar" . " </td>";
			echo "<td>" . "<input type=submit name=deletar value=deletar" . " </td>";	
			echo "</tr>";
			echo "</form>";
		}
		echo "</table>";	

		} 	
		/////////////DELETA////////////// 
		if (isset ($_POST['deletar'])){
		//$idreceita = $_POST['idreceita'];		
		//$idreceita = $_GET['Id_receita'];	
		$sqlDelete=("DELETE from receita WHERE Id_receita='$_POST[hidden]'");
		mysql_query($sqlDelete,$conexao); 
		//$myData or die(mysql_error());
		//$myData->execute();	
		echo "deletado!!";
		mostrarTabela();
	
		}
		/////////////ALTERA1////////////// 		
		if (isset ($_POST['alterar1'])){
		
		$sql=mysql_query("SELECT * FROM receita WHERE Id_receita='$_POST[hidden]'");
		$myData=$sql; 
		
		
	   	while($record = mysql_fetch_array($myData)){
			echo "<form method=POST action=receita.php>";
			//echo "<table border = 1>";
			echo "<table border = 1>
			<tr>
			<th>Nº Receita</th>
			<th>Descrição</th>
			<th>Data de pagamento</th>
			<th>Valor</th>
			</tr>";
			echo "<tr>";
			echo "<td>" . $record['Id_receita'] . " </td>";
			echo "<td>" . "<input type=text name=descricao value=" . $record['Ds_receita'] . " </td>";
			echo "<td>" . "<input type=text name=datapagamento value=". $record['Dt_Pagamento'] . " </td>";
			echo "<td>" . "<input type=text name=valor value=". $record['Vl_Receita'] . " </td>";
			echo "<td>" . "<input type=hidden name=hidden value=" . $record['Id_receita'] . " </td>";
			echo "<td>" . "<input type=submit name=alterar2 value=alterar" . " </td>";
			echo "<td>" . "<input type=button value=cancelar onClick=history.go(-1)" . " </td>";
			echo "</tr>";
			echo "</form>";
			echo "</table>";
			}
			
		}
		/////////////ALTERA2//////////////
		if (isset ($_POST['alterar2'])){

		$sqlUpdate=("UPDATE receita SET Ds_receita='$_POST[descricao]', Dt_Pagamento='$_POST[datapagamento]', Vl_Receita='$_POST[valor]' WHERE Id_receita='$_POST[hidden]'");
		mysql_query($sqlUpdate, $conexao); 
		//$myData or die(mysql_error());
		echo "modificado!";	
		 mostrarTabela();
		 mysql_close($conexao);
	}
		
			

		//mysql_close($conexao);

//thaystg@gmail.com	
?>


