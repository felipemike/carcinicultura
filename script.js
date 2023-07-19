function adicionarRacao() {
  const manhaInput = document.getElementById("manha");
  const tardeInput = document.getElementById("tarde");

  const manha = parseFloat(manhaInput.value) || 0;
  const tarde = parseFloat(tardeInput.value) || 0;
  const total = manha + tarde;

  // Fazer uma chamada AJAX para o arquivo PHP
  const xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
      // Atualizar a tabela com o lançamento adicionado
      const tbody = document.getElementById("table-body");
      tbody.innerHTML = this.responseText;

      // Limpar os campos de entrada
      manhaInput.value = "";
      tardeInput.value = "";

      // Atualizar o total de ração
      atualizarTotalRacao();
    }
  };
  xhttp.open("POST", "adicionar_lancamento.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  // Envie os valores de "manha" e "tarde" para o arquivo PHP
  const dataToSend = "manha=" + manha + "&tarde=" + tarde;
  xhttp.send(dataToSend);
}

function editarLancamento(button) {
  const row = button.parentNode.parentNode;
  const dataCell = row.cells[0];
  const manhaCell = row.cells[1];
  const tardeCell = row.cells[2];

  const data = dataCell.textContent;
  const manha = parseFloat(manhaCell.textContent) || 0;
  const tarde = parseFloat(tardeCell.textContent) || 0;

  // Fazer uma chamada AJAX para o arquivo PHP
  const xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
      // Atualizar a tabela com o lançamento atualizado
      const tbody = document.getElementById("table-body");
      tbody.innerHTML = this.responseText;

      // Atualizar o total de ração
      atualizarTotalRacao();
    }
  };
  xhttp.open("POST", "editar_lancamento.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  // Envie os valores de "data", "manha" e "tarde" para o arquivo PHP
  const dataToSend = "data=" + data + "&manha=" + manha + "&tarde=" + tarde;
  xhttp.send(dataToSend);
}

function atualizarTotalRacao() {
  // Fazer uma chamada AJAX para o arquivo PHP
  const xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
      // Atualizar o valor do total de ração
      const totalRacaoSpan = document.getElementById("totalRacao");
      totalRacaoSpan.textContent = this.responseText;
    }
  };
  xhttp.open("GET", "calcular_total_racao.php", true);
  xhttp.send();
}

function excluirLancamento(button) {
  const row = button.parentNode.parentNode;
  const dataCell = row.cells[0];
  const data = dataCell.textContent;

  // Fazer uma chamada AJAX para o arquivo PHP
  const xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
      // Atualizar a tabela com o lançamento removido
      const tbody = document.getElementById("table-body");
      tbody.innerHTML = this.responseText;

      // Atualizar o total de ração
      atualizarTotalRacao();
    }
  };
  xhttp.open("POST", "excluir_lancamento.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("data=" + data);
}