<?php
include 'header.php';
include 'dbconfig.php';

$today = date('Y-m-d');
$maxEndDate = date('Y-m-d', strtotime('+2 days'));
?>

<style>
  body, html {
    height: 100%;
    margin: 0;
    font-family: Arial, sans-serif;
  }

  body {
    background: 
      linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
      url('https://images.unsplash.com/photo-1558980664-10e7173e5d5e?auto=format&fit=crop&w=1470&q=80') no-repeat center center fixed;
    background-size: cover;
    color: #fff;
  }

  .container {
    background-color: rgba(0, 0, 0, 0.75);
    padding: 30px;
    border-radius: 10px;
    max-width: 960px;
    margin: 60px auto;
  }

  label {
    color: #fff;
    font-weight: bold;
  }

  input.form-control, select.form-control {
    background-color: #fff;
    border: 1px solid #ccc;
    color: #000;
  }

  input::placeholder {
    color: #999;
  }

  option {
    color: #000;
  }

  button.btn-primary {
    background-color: #28a745;
    border-color: #28a745;
    color: #fff;
  }

  button.btn-primary:hover {
    background-color: #218838;
    border-color: #1e7e34;
  }

  h2 {
    color: #fff;
    text-align: center;
    margin-bottom: 30px;
  }
</style>

<section>
  <div class="container">
    <h2>Find Your Perfect Ride</h2>
    <form class="row g-3 justify-content-center align-items-end" action="bikelist.php" method="POST">
      
      <!-- City dropdown -->
      <div class="col-md-3">
        <label for="location" class="form-label">Location</label>
        <select name="location" id="location" class="form-control" required>
          <option value="">-- Select City --</option>
          <option value="Bangalore">Bangalore</option>
          <option value="Mysore">Mysore</option>
          <option value="Mangalore">Mangalore</option>
          <option value="Hubli">Hubli</option>
          <option value="Belgaum">Belgaum</option>
        </select>
      </div>

      <div class="col-md-3">
        <label for="start_date" class="form-label">Start Date</label>
        <input type="date" name="start_date" id="start_date" class="form-control"
               value="<?= $today ?>" min="<?= $today ?>" max="<?= $today ?>" required>
      </div>

      <div class="col-md-3">
        <label for="end_date" class="form-label">End Date</label>
        <input type="date" name="end_date" id="end_date" class="form-control"
               value="<?= $maxEndDate ?>" min="<?= $today ?>" max="<?= $maxEndDate ?>" required>
      </div>

      <div class="col-md-2 d-grid">
        <button type="submit" class="btn btn-primary">Search</button>
      </div>
    </form>
  </div>
</section>

<script>
  const endDateInput = document.getElementById('end_date');
  const today = new Date().toISOString().split('T')[0];
  const maxEndDate = new Date();
  maxEndDate.setDate(maxEndDate.getDate() + 2);
  const maxDateStr = maxEndDate.toISOString().split('T')[0];

  endDateInput.min = today;
  endDateInput.max = maxDateStr;

  endDateInput.addEventListener('change', function () {
    if (this.value < today || this.value > maxDateStr) {
      alert("End date must be within 2 days from today.");
      this.value = maxDateStr;
    }
  });
</script>

<?php include 'footer.php'; ?>
