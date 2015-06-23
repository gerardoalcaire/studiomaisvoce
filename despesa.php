<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Despesa</title>
</head>
</html>
<?php
	function mostrarForm() {
	echo '<html>

	<form id="formulario" method="POST"action="despesa.php">
		<label><h3>Dados de Despesa</h3></label><br>
		
		<input type="hidden" name="iddespesa" id="iddespesa" /><br>
		
		<label>Descrição</label><br>
		<input type="text" name="descricao" id="descricao" size=80 /> <br>
		
		<label>Data de Pagamento</label><br>
		<input type="date" name="datapagamento" id="datapagamento" /> <br>

		<label>Valor</label><br>
		<input type="text" name="valor" id="valor" size=30 />
		<input type="checkbox" name="produto" id="produto" /> Produto
		<input type="checkbox" name="caixa" id="caixa"  /> Caixa
		<br><br>
		
		<input type="submit" name="submit"/>
	
	<br>
	</form>
	</html>';
	//echo "<b>Todos os campos são obrigatorios</b>";
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
		$iddespesa=$_POST['iddespesa'];	
		$descricao=$_POST['descricao'];
		$datapagamento=$_POST['datapagamento'];
		$valor=$_POST['valor'];	
		//$_POST['produto']='0';
			if (isset($_POST['produto'])){
				$_POST['produto']=1;
			}
			else{
				$_POST['produto']=0;
			}

			if (isset($_POST['caixa'])){
				$_POST['caixa']=1;
			}
			else{
				$_POST['caixa']=0;
			}
		$produto=$_POST['produto'];
		$caixa=$_POST['caixa'];
		/*
		echo "produto "."$produto";
		echo "<br>";
		echo "caixa "."$caixa";
		*/
		$sql=mysql_query("INSERT INTO despesa (Ds_despesa, Dt_Pagamento, Vl_Despesa, Produto, Caixa)VALUES('$descricao', '$datapagamento', '$valor', $produto, $caixa)");
		
		mostrarTabela();
		}

		/////////////MOSTRA TABELA COM INSERÇÕES////////////// 
		function mostrarTabela(){			
		
		$sql=mysql_query("SELECT * FROM despesa");
		$myData=$sql; 
		echo "<table border = 1>
		<tr>
		<th>Nº Despesa</th>
		<th>Descrição</th>
		<th>Data de pagamento</th>
		<th>Valor</th>
		<th>Produto</th>
		<th>Caixa</th>
		</tr>";
	
			while($record = mysql_fetch_array($myData)){
			echo "<form action=despesa.php method=post>";
			echo "<tr>";
			echo "<td>" . $record['Id_Despesa'] . "</td>";
			echo "<td>" . $record['Ds_Despesa'] . " </td>";	
			echo "<td>" . $record['Dt_Pagamento'] . " </td>";
			echo "<td>" . $record['Vl_Despesa'] . " </td>";
			echo "<td>" . $record['Produto'] . " </td>";
			echo "<td>" . $record['Caixa'] . " </td>";
			echo "<td>" . "<input type=hidden name=hidden value=" . $record['Id_Despesa'] . "</td>";
			echo "<td>" . "<input type=submit name=alterar1 value=alterar" . " </td>";
			echo "<td>" . "<input type=submit name=deletar value=deletar" . " </td>";	
			echo "</tr>";
			echo "</form>";
			}
			echo "</table>";	

		} 	
		/////////////DELETA////////////// 
		if (isset ($_POST['deletar'])){
		//$iddespesa = $_POST['iddespesa'];		
		//$iddespesa = $_GET['Id_despesa'];	
		$sqlDelete=("DELETE from despesa WHERE Id_Despesa='$_POST[hidden]'");
		mysql_query($sqlDelete,$conexao); 
		//$myData or die(mysql_error());
		//$myData->execute();	
		//echo "deletado!!";
		mostrarTabela();
	
		}
		/////////////ALTERA1////////////// 		
		if (isset ($_POST['alterar1'])){
		
		$sql=mysql_query("SELECT * FROM despesa WHERE Id_Despesa='$_POST[hidden]'");
		$myData=$sql; 
		
		
	   	while($record = mysql_fetch_array($myData)){
			echo "<form method=POST action=despesa.php>";
			//echo "<table border = 1>";
			echo "<table border = 1>
			<tr>
			<th>Nº Despesa</th>
			<th>Descrição</th>
			<th>Data de pagamento</th>
			<th>Valor</th>
			<th>Produto</th>
			<th>Caixa</th>
			</tr>";
			echo "<tr>";
			echo "<td>" . $record['Id_Despesa'] . " </td>";
			echo "<td>" . "<input type=text name=descricao value=" . $record['Ds_Despesa'] . " </td>";
			echo "<td>" . "<input type=text name=datapagamento value=". $record['Dt_Pagamento'] . " </td>";
			echo "<td>" . "<input type=text name=valor value=". $record['Vl_Despesa'] . " </td>";
			echo "<td>" . "<input type=text name=produto value=". $record['Produto'] . " </td>"; 
			echo "<td>" . "<input type=text name=caixa value=". $record['Caixa'] . " </td>";
			echo "<td>" . "<input type=hidden name=hidden value=" . $record['Id_Despesa'] . " </td>";
			echo "<td>" . "<input type=submit name=alterar2 value=alterar" . " </td>";
			echo "<td>" . "<input type=button value=cancelar onClick=history.go(-1)" . " </td>";
			echo "</tr>";
			echo "</form>";
			echo "</table>";
			}
			
		}
		/////////////ALTERA2//////////////
		if (isset ($_POST['alterar2'])){

		$sqlUpdate=("UPDATE despesa SET Ds_despesa='$_POST[descricao]', Dt_Pagamento='$_POST[datapagamento]', Produto='$_POST[produto]', Vl_Despesa='$_POST[valor]', Caixa='$_POST[caixa]' WHERE Id_despesa='$_POST[hidden]'");
		mysql_query($sqlUpdate, $conexao); 
		//$myData or die(mysql_error());
		echo "modificado!";	
		 mostrarTabela();
		 mysql_close($conexao);
	}
		
			

		//mysql_close($conexao);

//thaystg@gmail.com	
?>


