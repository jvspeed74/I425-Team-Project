<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formula 1 Drivers</title>
        <link rel="stylesheet" href="css/global.css">
        <script>
            let allDrivers = [];
            const driversPerPage = 5;
            let currentPage = 1;

            document.addEventListener("DOMContentLoaded", function() {
                fetchDrivers();
                document.querySelector('#search').addEventListener('input', filterDrivers);
            });

            function fetchDrivers() {
                fetch('http://localhost:8080/drivers')
                    .then(response => response.json())
                    .then(drivers => {
                    allDrivers = drivers;
                    renderDrivers();
                    renderPagination();
                })
                .catch(error => console.error('Error fetching drivers:', error));
            }

            function renderDriverItem(driver) {
                const driverItem = document.createElement('div');
                driverItem.classList.add('driver-item');
                driverItem.innerHTML = `
                    <h3>${driver.first_name} ${driver.last_name}</h3>
                    <p><strong>Driver Number:</strong> ${driver.driver_number}</p>
                    <p><strong>Birthday:</strong> ${driver.birthday}</p>
                    <div class="driver-info">
                        <p><strong>Team:</strong> ${driver.team_id}</p>
                        <p><strong>Nationality:</strong> ${driver.nationality_id}</p>
                    </div>
                    <div class="driver-stats">
                        <p><span>Career Points:</span> ${driver.career_points}</p>
                        <p><span>Career Wins:</span> ${driver.career_wins}</p>
                        <p><span>Career Podiums:</span> ${driver.career_podiums}</p>
                        <p><span>Championships:</span> ${driver.championships}</p>
                    </div>
                `;
                return driverItem;
            }

            function renderDrivers() {
                const driverList = document.querySelector('.driver-list');
                driverList.innerHTML = '';

                const filteredDrivers = getFilteredDrivers();

                const startIndex = (currentPage - 1) * driversPerPage;
                const endIndex = startIndex + driversPerPage;
                const driversToDisplay = filteredDrivers.slice(startIndex, endIndex);

                driversToDisplay.forEach(driver => {
                    driverList.appendChild(renderDriverItem(driver));
                });
            }

            function getFilteredDrivers() {
                const searchQuery = document.querySelector('#search').value.toLowerCase();
                return allDrivers.filter(driver => {
                    const fullName = `${driver.first_name} ${driver.last_name}`.toLowerCase();
                    return fullName.includes(searchQuery) ||
                        driver.driver_number.toString().includes(searchQuery) ||
                        driver.career_points.toString().includes(searchQuery) ||
                        driver.career_wins.toString().includes(searchQuery) ||
                        driver.career_podiums.toString().includes(searchQuery) ||
                        driver.championships.toString().includes(searchQuery);
                });
            }

            function renderPagination() {
                const filteredDrivers = getFilteredDrivers();
                const totalPages = Math.ceil(filteredDrivers.length / driversPerPage);
                const pagination = document.querySelector('.pagination');
                pagination.innerHTML = '';

                for (let i = 1; i <= totalPages; i++) {
                    const pageBtn = document.createElement('button');
                    pageBtn.classList.add('page-btn');
                    pageBtn.innerText = i;
                    pageBtn.onclick = () => {
                        currentPage = i;
                        renderDrivers();
                    };
                    pagination.appendChild(pageBtn);
                }
            }

            function filterDrivers() {
                currentPage = 1;
                renderDrivers();
                renderPagination();
            }
        </script>
    </head>
    <body>
        <header>
            <div class="container">
                <h1>Formula 1 Drivers</h1>
                <nav>
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="/tracksPage">Tracks</a></li>
                        <li><a href="/eventsPage">Events</a></li>
                        <li><a href="/driversPage">Drivers</a></li>
                        <li><a href="/teamsPage">Teams</a></li>
                        <li><a href="/carsPage">Cars</a></li>
                        <li><a href="/signin" class="signin-btn">Sign In</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <section id="drivers" class="section">
            <div class="container">
                <h2>Formula 1 Drivers</h2>
                <p>Meet the drivers of Formula 1 and learn more about their careers and achievements.</p>
                <input type="text" id="search" placeholder="Search by name or stats" class="search-box">
                <div class="driver-list"></div>
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
