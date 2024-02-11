const searchInput = document.getElementById("search");
const searchResultsContainer = document.getElementById("search-results");

searchInput.addEventListener("input", function () {
  const searchQuery = searchInput.value.trim();

  if (searchQuery.length === 0) {
    searchResultsContainer.innerHTML = "";
    return;
  }

  const xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      const results = JSON.parse(xhr.responseText);
      displaySearchResults(results);
    }
  };

  xhr.open("GET", `search_products.php?query=${searchQuery}`, true);
  xhr.send();
});

function displaySearchResults(results) {
  let html = "";

  results.forEach((result) => {
    html += `<a href="quick_view.php?pid=${result.id}">${result.name}</a>`;
  });

  searchResultsContainer.innerHTML = html;
}
