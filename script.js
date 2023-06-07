const mysql = require('mysql2');

let connection;

async function main() {
    connection = mysql.createPool({
      host: "aws.connect.psdb.cloud",
      user: "3yp6c2uj56601x90oamx",
      password: "pscale_pw_YvAqoKrO2NuAlKdaHynDKqA4qACOdXSDz3QCcN0HvCs",
      database: "felipe",
      ssl: {
        rejectUnauthorized: false
      }
    });
    console.log('Conectado ao banco de dados!');
}
main();

function adicionarRacao() {
  const dataAtual = new Date();
  const manhaInput = document.getElementById("manha");
  const tardeInput = document.getElementById("tarde");
  const tbody = document.getElementById("table-body");

  const manha = parseFloat(manhaInput.value);
  const tarde = parseFloat(tardeInput.value);
  const total = manha + tarde;

  const row = document.createElement("tr");

  const dataCell = document.createElement("td");
  dataCell.textContent = dataAtual.toLocaleDateString();
  row.appendChild(dataCell);

  const manhaCell = document.createElement("td");
  manhaCell.textContent = manha;
  row.appendChild(manhaCell);

  const tardeCell = document.createElement("td");
  tardeCell.textContent = tarde;
  row.appendChild(tardeCell);

  const totalCell = document.createElement("td");
  totalCell.textContent = total;
  row.appendChild(totalCell);

  const actionCell = document.createElement("td");
  const deleteButton = document.createElement("button");
  deleteButton.textContent = "x";
  deleteButton.addEventListener("click", function() {
    excluirLancamento(row);
  });
  actionCell.appendChild(deleteButton);
  row.appendChild(actionCell);

  tbody.appendChild(row);

  manhaInput.value = "";
  tardeInput.value = "";

  const query = 'INSERT INTO Entries (data, manha, tarde) VALUES (?, ?, ?)';
  const values = [dataAtual, manha, tarde];

  connection.query(query, values, function (error, results, fields) {
    if (error) {
      console.error('Erro ao registrar os dados da ração:', error.message);
    } else {
      console.log('Dados da ração registrados no banco de dados!');
      atualizarTotalRacaoEDias();
    }
  });

  atualizarTotalRacaoEDias();
}

function excluirLancamento(row) {
  const tbody = document.getElementById("table-body");
  tbody.removeChild(row);

  atualizarTotalRacaoEDias();
}

function atualizarTotalRacaoEDias() {
  const tbody = document.getElementById("table-body");
  const rows = tbody.getElementsByTagName("td");
  let totalRacao = 0;
  
  for (let i = 0; i < rows.length; i++) {
  const row = rows[i];
  const totalCell = row.getElementsByTagName("td")[3];
  const total = parseFloat(totalCell.textContent);
  totalRacao += total;
  }
  
  const totalRacaoElement = document.getElementById("totalRacao");
  
  totalRacaoElement.textContent = totalRacao.toFixed(2);
  }
