<div>
<h4>Company distributon</h4>
  <canvas id="infoChart"></canvas>
  
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctz = document.getElementById('infoChart');

  new Chart(ctz, {
    type: 'pie',
    data: {
      labels: ['orders', 'clients', 'leads', 'transcations','interactions'],
      datasets: [{
        label: '# of Votes',
        data: [10, 15, 30,10 ,50],
        borderWidth: 1
      }]
    },
  });

  
</script>