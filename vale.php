<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Vale</title>
</head>
</html>
<?php
	function mostrarForm() {
	echo '<html>	
	<form id="formulario" method="POST" action="vale.php">
		<label><h3>Vale</h3></label><br> 
		
		 <input type="hidden" name="idfunc" id="idfunc" />
		 <input type="hidden" name="idvale" id="idvale" /><br>
		<label>Funcionario</label><br>
		<select name="nome">
 		<option>Selecione...</option>
	</html>';
	
	mostrarSelectTag();
	 		
	echo '<html>
		</select>
		<br>
		<label>Data</label><br>
		<input type="date" name="data" id="data" size=10/> <br>

		<label>Valor</label><br>
		<input type="text" name="valor" id="valor" size=30 /> 
		<br><br>
		
		<input type="submit" name="submit"/>
	<br>
	</form>
	</html>';
	}
	
	///////////CONEXÃO COM BANCO///////////////////////
	 $server = "localhost";
	 $usuario = "root";
	 $pass = "";
	 $banco = "studiomaisvoce";
	 
	 $conexao = mysql_connect($server, $usuario, $pass, $banco) or die (mysql_error());
	 mysql_select_db($banco) or die(mysql_error());	
		
		

	/////////////MOSTRA TABELA COM INSERÇÕES////////////// 
	function mostrarSelectTag(){		
		$server = "localhost";
	 	$usuario = "root";
	 	$pass = "";
	 	$banco = "studiomaisvoce";
	 
	 	$conexao = mysql_connect($server, $usuario, $pass, $banco) or die (mysql_error());
	 	mysql_select_db($banco) or die(mysql_error());		
		
		$sql=mysql_query("SELECT Id_Func, Nm_Func FROM funcionario");
		$myData=$sql; 

			while($record = mysql_fetch_array($myData)){
			echo "<form action=vale.php method=post>";
			echo "<option>" . $record['Nm_Func'] . "</option>";
		 	echo "</form>";       	
			
			}
			
	} 	
 
	 	//MOSTRA FORM HTML
		mostrarForm();	

		/////////////INSERE////////////// 		
		if (isset($_POST['submit'])&&($_POST['valor'])){	
		
		$datavale=$_POST['data'];
		$valor=$_POST['valor'];	
		$nome=$_POST['nome'];
		$id=mysql_query("SELECT Id_Func FROM funcionario WHERE Nm_Func='$nome'");
		//fetch_row senão não retornava o id
		$idresult = mysql_fetch_row($id);
		$idfuncionario = $idresult[0];
		//echo "$idfuncionario";
		$sql=mysql_query("INSERT INTO vale (Id_Funcionario, Dt_Vale, Vl_Vale)VALUES('$idfuncionario', '$datavale', '$valor')");
		
		mostrarTabela();
		}

		/////////////MOSTRA TABELA COM INSERÇÕES////////////// 
		function mostrarTabela(){			
		
		$sql=mysql_query("SELECT funcionario.Nm_Func, vale.Id_Vale, vale.Dt_Vale, vale.Vl_Vale, vale.Id_Funcionario FROM funcionario, vale WHERE funcionario.Id_Func=vale.Id_Funcionario");
		$myData=$sql; 
		echo "<table border = 1>
		<tr>
		<th>Nº Vale</th>
		<th>Nome do funcionario</th>
		<th>Data</th>
		<th>Valor</th>
		</tr>";
	
			while($record = mysql_fetch_array($myData)){
			echo "<form action=vale.php method=post>";
			echo "<tr>";
			echo "<td>" . $record['Id_Vale'] . "</td>";
			echo "<td>" . $record['Nm_Func'] . " </td>";	
			echo "<td>" . $record['Dt_Vale'] . " </td>";
			echo "<td>" . $record['Vl_Vale'] . " </td>";
			echo "<td>" . "<input type=hidden name=hidden value=" . $record['Id_Vale'] . "</td>";
			echo "<td>" . "<input type=submit name=alterar1 value=alterar" . " </td>";
			echo "<td>" . "<input type=submit name=deletar value=deletar" . " </td>";	
			echo "</tr>";
			echo "</form>";
			}
			echo "</table>";	

		} 
		/////////////DELETA////////////// 	
		if (isset ($_POST['deletar'])){
		
		$sqlDelete=("DELETE from vale WHERE Id_Vale='$_POST[hidden]'");
		mysql_query($sqlDelete,$conexao); 
		//$myData or die(mysql_error());
		//$myData->execute();	
		//echo "deletado!!";
		mostrarTabela();
	
		}
		/////////////ALTERA1////////////// 		
		if (isset ($_POST['alterar1'])){
		
		$sql=mysql_query("SELECT funcionario.Nm_Func, vale.Id_Vale, vale.Dt_Vale, vale.Vl_Vale, vale.Id_Funcionario FROM funcionario, vale WHERE vale.Id_Vale='$_POST[hidden]' AND funcionario.Id_Func=vale.Id_Funcionario");
		$myData=$sql; 
		
		
	   	while($record = mysql_fetch_array($myData)){
			echo "<form method=POST action=vale.php>";
			echo "<table border = 1>
			<tr>
			<th>Nº Vale</th>
			<th>Nome do funcionario</th>
			<th>Data</th>
			<th>Valor</th>
			</tr>";
			echo "<tr>";
			echo "<td>" . $record['Id_Vale'] . " </td>";
			echo "<td>" . $record['Nm_Func'] . " </td>";
			//echo "<td>" . "<select name=nome>" . "<option>" . mostrarSelectTag() . "</option>" . "</select>" . " </td>";
			echo "<td>" . "<input type=text name=data value=". $record['Dt_Vale'] . " </td>";
			echo "<td>" . "<input type=text name=valor value=". $record['Vl_Vale'] . " </td>";
			echo "<td>" . "<input type=hidden name=hidden value=" . $record['Id_Vale'] . " </td>";
			echo "<td>" . "<input type=submit name=alterar2 value=alterar" . " </td>";
			echo "<td>" . "<input type=button value=cancelar onClick=history.go(-1)" . " </td>";
			echo "</tr>";
			echo "</form>";
			echo "</table>";
			}
			
		}
		/////////////ALTERA2//////////////
		if (isset ($_POST['alterar2'])){

		$sqlUpdate=("UPDATE vale SET Dt_Vale='$_POST[data]', Vl_Vale='$_POST[valor]' WHERE Id_Vale='$_POST[hidden]'");
		mysql_query($sqlUpdate, $conexao); 
		//$myData or die(mysql_error());
		//echo "modificado!";	
		 mostrarTabela();
		 mysql_close($conexao);
	}



	/*<select name="funcionario">
		 <option value="func1">Maria</option>
		 <option value="func2">Jose</option>
         <option value="func3">Lia</option>
         <option value="func4">Joana</option>
         </select><br>

 	<input type="text" name="funcionario" id="funcionario" size=50 /> <br>
		 
	*/	 
?>		 