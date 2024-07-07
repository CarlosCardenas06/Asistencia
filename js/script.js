document.getElementById('attendanceForm').addEventListener('submit', function(event) {
  event.preventDefault();
  var formData = new FormData(this);
  
  fetch('php/registro.php', {
      method: 'POST',
      body: formData
  })
  .then(response => response.text())
  .then(data => {
      alert(data);
      loadAttendanceList();
  });
});

function loadAttendanceList() {
  fetch('php/listar_asistencia.php')
  .then(response => response.text())
  .then(data => {
      document.getElementById('list').innerHTML = data;
  });
}

function generateReport() {
  window.open('php/reporte.php', '_blank');
}

window.onload = loadAttendanceList;

// Manejo del Dialog para agregar empleado
var modal = document.getElementById("addEmployeeModal");
var btn = document.getElementById("addEmployeeBtn");
var span = document.getElementsByClassName("close")[0];

btn.onclick = function() {
  modal.style.display = "block";
}

span.onclick = function() {
  modal.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal) {
      modal.style.display = "none";
  }
}

document.getElementById('addEmployeeForm').addEventListener('submit', function(event) {
  event.preventDefault();
  var formData = new FormData(this);
  
  fetch('php/agregar_empleado.php', {
      method: 'POST',
      body: formData
  })
  .then(response => response.text())
  .then(data => {
      alert(data);
      modal.style.display = "none";
      this.reset();
  });
});
