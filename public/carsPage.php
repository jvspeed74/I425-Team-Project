<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formula 1 Cars</title>
        <link rel="stylesheet" href="css/global.css">
        <script>
            let allCars = [];
            let currentPage = 1;
            const carsPerPage = 5;

            document.addEventListener("DOMContentLoaded", function() {
                fetchCars();
                document.querySelector('#search').addEventListener('input', filterCars);
            });

            function fetchCars() {
                fetch('http://localhost:8080/cars')
                    .then(response => response.json())
                .then(cars => {
                    allCars = cars;
                    renderCars();
                    renderPagination();
                })
                .catch(error => console.error('Error fetching cars:', error));
            }

            function renderCars() {
                const carList = document.querySelector('.car-list');
                carList.innerHTML = '';

                const filteredCars = getFilteredCars();

                const startIndex = (currentPage - 1) * carsPerPage;
                const endIndex = startIndex + carsPerPage;
                const carsToDisplay = filteredCars.slice(startIndex, endIndex);

                carsToDisplay.forEach(car => {
                    const carItem = document.createElement('div');
                    carItem.classList.add('car-item');
                    carItem.innerHTML = `
                        <h3>Model:</strong> ${car.model}</h3>
                        <p><strong>Year:</strong> ${car.year}</p>
                    `;
                    carList.appendChild(carItem);
                });
            }

            function getFilteredCars() {
                const searchQuery = document.querySelector('#search').value.toLowerCase();
                return allCars.filter(car => {
                    return car.model.toLowerCase().includes(searchQuery) ||
                        car.year.toString().includes(searchQuery);
                });
            }

            function renderPagination() {
                const filteredCars = getFilteredCars();
                const totalPages = Math.ceil(filteredCars.length / carsPerPage);
                const pagination = document.querySelector('.pagination');
                pagination.innerHTML = '';

                for (let i = 1; i <= totalPages; i++) {
                    const pageBtn = document.createElement('button');
                    pageBtn.classList.add('page-btn');
                    pageBtn.innerText = i;
                    pageBtn.onclick = () => {
                        currentPage = i;
                        renderCars();
                    };
                    pagination.appendChild(pageBtn);
                }
            }

            function filterCars() {
                currentPage = 1;
                renderCars();
                renderPagination();
            }
        </script>
    </head>
    <body>
    <header>
        <div class="container">
            <h1>Formula 1 Cars</h1>
            <nav>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/tracksPage">Tracks</a></li>
                    <li><a href="/eventsPage">Events</a></li>
                    <li><a href="/driversPage">Drivers</a></li>
                    <li><a href="/teamsPage">Teams</a></li>
                    <li><a href="/carsPage">Cars</a> </li>
                    <li><a href="/signin" class="signin-btn">Sign In</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <section id="cars" class="section">
        <div class="container">
            <h2>Formula 1 Cars</h2>
            <p>Explore the cars used by the top teams in Formula 1.</p>
            <input type="text" id="search" placeholder="Search by model or year" class="search-box">
            <div class="car-list"></div>
            <div class="pagination"></div>
        </div>
    </section>
    <footer>
        <div class="container">
            <p>&copy; 2024 Formula 1 Center. All Rights Reserved.</p>
        </div>
    </footer>
    </body>
</html>
