
document.addEventListener("DOMContentLoaded", () => {
  const tableBody = document.querySelector("tbody");
  const searchInput = document.getElementById("searchInput");

  if (tableBody) {
    fetch("backend/get_items.php")
      .then(res => res.json())
      .then(items => {
        tableBody.innerHTML = "";
        items.forEach(item => {
          const row = document.createElement("tr");
          row.innerHTML = `
            <td>${item.name}</td>
            <td>${item.date_lost}</td>
            <td><span class="status ${item.status}">${item.status}</span></td>
            <td>
              <button onclick="claimItem(${item.id})" class="btn btn-success btn-sm">Claim</button>
              <button onclick="deleteItem(${item.id})" class="btn btn-danger btn-sm">Delete</button>
            </td>
          `;
          tableBody.appendChild(row);
        });
      });
  }

  window.claimItem = function (id) {
    fetch("backend/claim_item.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "id=" + id
    }).then(res => res.json()).then(result => {
      if (result.success) {
        alert("Item claimed!");
        location.reload();
      }
    });
  };

  window.deleteItem = function (id) {
    if (!confirm("Are you sure you want to delete this item?")) return;
    fetch("backend/delete_item.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "id=" + id
    }).then(res => res.json()).then(result => {
      if (result.success) {
        alert("Item deleted!");
        location.reload();
      }
    });
  };

  window.filterAdminItems = function () {
    const input = searchInput ? searchInput.value.toLowerCase() : "";
    const rows = document.querySelectorAll("tbody tr");
    rows.forEach(row => {
      const text = row.textContent.toLowerCase();
      row.style.display = text.includes(input) ? "" : "none";
    });
  };

  const lostForm = document.getElementById("lostForm");
  if (lostForm) {
    lostForm.addEventListener("submit", function(e) {
      e.preventDefault();
      const formData = new FormData(lostForm);
      fetch("backend/add_lost_item.php", {
        method: "POST",
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        const msg = document.getElementById("formMessage");
        if (data.success) {
          msg.textContent = "✅ Item reported successfully!";
          msg.style.color = "green";
          lostForm.reset();
        } else {
          msg.textContent = "❌ Failed: " + (data.error || "Unknown error.");
          msg.style.color = "red";
        }
      })
      .catch(() => {
        const msg = document.getElementById("formMessage");
        msg.textContent = "❌ Network error.";
        msg.style.color = "red";
      });
    });
  }
});
