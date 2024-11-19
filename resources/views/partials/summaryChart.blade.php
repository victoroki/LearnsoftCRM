<div>
<h4>Summary</h4>
  <canvas id="sumChart"></canvas>
 
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const cts = document.getElementById('sumChart');

  new Chart(cts, {
    type: 'doughnut',
    data: {
      labels: ['employees','departments','interactions'],
      datasets: [{
        label: '# of Votes',
        data: [25, 5, 50,],
        borderWidth: 1
      }]
    },
  });
</script>