<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kpop Dancers CRUD</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
  <div class="container mt-5">
    <h2>Kpop Dancers</h2>

    <!-- Form for Adding Dancers -->
    <form id="dancerForm">
      <input type="hidden" id="id" />
      <div class="row">
        <div class="col">
          <input type="text" id="name" name="name" class="form-control" placeholder="Name" required />
        </div>
        <div class="col">
          <input type="text" id="stage_name" name="stage_name" class="form-control" placeholder="Stage Name" required />
        </div>
      </div>
      <div class="row mt-3">
        <div class="col">
          <input type="number" id="age" name="age" class="form-control" placeholder="Age" required />
        </div>
        <div class="col">
          <input type="text" id="sex" name="sex" class="form-control" placeholder="Sex" required />
        </div>
      </div>
      <div class="row mt-3">
        <div class="col">
          <input type="text" id="kgroup" name="kgroup" class="form-control" placeholder="Kpop Group" required />
        </div>
        <div class="col">
          <input type="text" id="company" name="company" class="form-control" placeholder="Company" required />
        </div>
      </div>
      <div class="row mt-3">
        <div class="col">
          <input type="number" id="debut_year" name="debut_year" class="form-control" placeholder="Debut Year" required />
        </div>
        <div class="col">
          <input type="text" id="nationality" name="nationality" class="form-control" placeholder="Nationality" required />
        </div>
      </div>
      <div class="row mt-4 text-center">
        <div class="col">
          <button type="submit" id="submit" name="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </form>

    <!-- Table for Displaying Dancers -->
    <div class="mt-5">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Stage Name</th>
            <th>Age</th>
            <th>Sex</th>
            <th>Kpop Group</th>
            <th>Company</th>
            <th>Debut Year</th>
            <th>Nationality</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="dancerstable">
          <!-- Dancers will be displayed here -->
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal for Editing Dancer -->
  <div class="modal fade" id="editDancerModal" tabindex="-1" aria-labelledby="editDancerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editDancerModalLabel">Edit Dancer</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Form for Editing Dancer -->
          <form id="editDancerForm">
            <input type="hidden" id="edit_id" />
            <div class="mb-3">
              <label for="edit_name" class="form-label">Name</label>
              <input type="text" id="edit_name" name="name" class="form-control" required />
            </div>
            <div class="mb-3">
              <label for="edit_stage_name" class="form-label">Stage Name</label>
              <input type="text" id="edit_stage_name" name="stage_name" class="form-control" required />
            </div>
            <div class="mb-3">
              <label for="edit_age" class="form-label">Age</label>
              <input type="number" id="edit_age" name="age" class="form-control" required />
            </div>
            <div class="mb-3">
              <label for="edit_sex" class="form-label">Sex</label>
              <input type="text" id="edit_sex" name="sex" class="form-control" required />
            </div>
            <div class="mb-3">
              <label for="edit_kgroup" class="form-label">Kpop Group</label>
              <input type="text" id="edit_kgroup" name="kgroup" class="form-control" required />
            </div>
            <div class="mb-3">
              <label for="edit_company" class="form-label">Company</label>
              <input type="text" id="edit_company" name="company" class="form-control" required />
            </div>
            <div class="mb-3">
              <label for="edit_debut_year" class="form-label">Debut Year</label>
              <input type="number" id="edit_debut_year" name="debut_year" class="form-control" required />
            </div>
            <div class="mb-3">
              <label for="edit_nationality" class="form-label">Nationality</label>
              <input type="text" id="edit_nationality" name="nationality" class="form-control" required />
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Update Dancer</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

  <script>
  let dancers = []; // Declare dancers globally

  document.getElementById('dancerForm').addEventListener('submit', async function (e) {
    e.preventDefault(); // Prevent the form from reloading the page

    const id = document.getElementById('id').value; // Get the ID (empty if adding)
    const dancerData = {
      name: document.getElementById('name').value,
      stage_name: document.getElementById('stage_name').value,
      age: document.getElementById('age').value,
      sex: document.getElementById('sex').value,
      kgroup: document.getElementById('kgroup').value,
      company: document.getElementById('company').value,
      debut_year: document.getElementById('debut_year').value,
      nationality: document.getElementById('nationality').value
    };

    const url = id ? `http://localhost:3000/kpop_dancers/${id}` : 'http://localhost:3000/kpop_dancers';
    const method = id ? 'PUT' : 'POST'; // Use PUT if updating, POST if adding

    try {
      const response = await fetch(url, {
        method: method,
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(dancerData)
      });

      if (!response.ok) {
        throw new Error(`Error: ${response.status} ${response.statusText}`);
      }

      const result = await response.json();
      console.log(`${id ? 'Dancer updated' : 'Dancer added'} successfully:`, result);

      // Clear the form and reload the dancers list
      document.getElementById('dancerForm').reset();
      loadDancers();
    } catch (error) {
      console.error(`Error ${id ? 'updating' : 'adding'} dancer:`, error);
    }
  });

  // Fetch and display dancers from the API
  async function loadDancers() {
    try {
      const response = await fetch('http://localhost:3000/kpop_dancers');
      dancers = await response.json(); // Assign to global dancers variable

      const tableBody = document.getElementById('dancerstable');
      tableBody.innerHTML = ''; // Clear any existing rows

      dancers.forEach(dancer => {
        const row = `
          <tr>
            <td>${dancer.id}</td>
            <td>${dancer.name}</td>
            <td>${dancer.stage_name}</td>
            <td>${dancer.age}</td>
            <td>${dancer.sex}</td>
            <td>${dancer.kgroup}</td>
            <td>${dancer.company}</td>
            <td>${dancer.debut_year}</td>
            <td>${dancer.nationality}</td>
            <td>
              <button class="btn btn-warning" onclick="openEditModal(${dancer.id})">Edit</button>
              <button class="btn btn-danger" onclick="deleteDancer(${dancer.id})">Delete</button>
            </td>
          </tr>
        `;
        tableBody.innerHTML += row;
      });
    } catch (error) {
      console.error('Error loading dancers:', error);
    }
  }

  function openEditModal(id) {
  console.log("ID passed to openEditModal:", id); // Log the ID passed
  console.log("Available dancers:", dancers); // Log available dancers

  const dancer = dancers.find(d => d.id.toString() === id.toString());
  if (dancer) { // Check if dancer exists
    document.getElementById('edit_id').value = dancer.id;
    document.getElementById('edit_name').value = dancer.name;
    document.getElementById('edit_stage_name').value = dancer.stage_name;
    document.getElementById('edit_age').value = dancer.age;
    document.getElementById('edit_sex').value = dancer.sex;
    document.getElementById('edit_kgroup').value = dancer.kgroup;
    document.getElementById('edit_company').value = dancer.company;
    document.getElementById('edit_debut_year').value = dancer.debut_year;
    document.getElementById('edit_nationality').value = dancer.nationality;

    // Show the modal
    const editModal = new bootstrap.Modal(document.getElementById('editDancerModal'));
    editModal.show();
  } else {
    console.error('Dancer not found');
  }
}

  // Handle editing the dancer
  document.getElementById('editDancerForm').addEventListener('submit', async function (e) {
    e.preventDefault(); // Prevent the form from reloading the page

    const id = document.getElementById('edit_id').value;
    const dancerData = {
      name: document.getElementById('edit_name').value,
      stage_name: document.getElementById('edit_stage_name').value,
      age: document.getElementById('edit_age').value,
      sex: document.getElementById('edit_sex').value,
      kgroup: document.getElementById('edit_kgroup').value,
      company: document.getElementById('edit_company').value,
      debut_year: document.getElementById('edit_debut_year').value,
      nationality: document.getElementById('edit_nationality').value
    };

    try {
      const response = await fetch(`http://localhost:3000/kpop_dancers/${id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(dancerData)
      });

      if (!response.ok) {
        throw new Error(`Error: ${response.status} ${response.statusText}`);
      }

      const result = await response.json();
      console.log('Dancer updated successfully:', result);

      // Close the modal and reload the dancers list
      const editModal = bootstrap.Modal.getInstance(document.getElementById('editDancerModal'));
      editModal.hide();
      loadDancers();
    } catch (error) {
      console.error('Error updating dancer:', error);
    }
  });

  // Delete dancer function
  async function deleteDancer(id) {
    if (confirm('Are you sure you want to delete this dancer?')) {
      try {
        const response = await fetch(`http://localhost:3000/kpop_dancers/${id}`, {
          method: 'DELETE'
        });

        if (!response.ok) {
          throw new Error(`Error: ${response.status} ${response.statusText}`);
        }

        alert('Dancer deleted successfully');
        loadDancers(); // Reload dancers
      } catch (error) {
        console.error('Error deleting dancer:', error);
      }
    }
  }

  // Load dancers on page load
  loadDancers();
</script>

</body>

</html>
