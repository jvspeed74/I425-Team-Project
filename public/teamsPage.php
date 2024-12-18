<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formula 1 Teams</title>
        <link rel="stylesheet" href="css/global.css">
        <script>
            let allTeams = [];
            let currentPage = 1;
            const teamsPerPage = 5;

            document.addEventListener("DOMContentLoaded", function() {
                fetchTeams();
                document.querySelector('#search').addEventListener('input', filterTeams);
            });

            function fetchTeams() {
                fetch('http://localhost:8080/teams')
                    .then(response => response.json())
                    .then(teams => {
                    allTeams = teams;
                    renderTeams();
                    renderPagination();
                })
                .catch(error => console.error('Error fetching teams:', error));
            }

            function renderTeams() {
                const teamList = document.querySelector('.team-list');
                teamList.innerHTML = '';

                const filteredTeams = getFilteredTeams();

                const startIndex = (currentPage - 1) * teamsPerPage;
                const endIndex = startIndex + teamsPerPage;
                const teamsToDisplay = filteredTeams.slice(startIndex, endIndex);

                teamsToDisplay.forEach(team => {
                    const teamItem = document.createElement('div');
                    teamItem.classList.add('team-item');
                    teamItem.innerHTML = `
                        <h3>${team.official_name}</h3>
                        <p><strong>Short Name:</strong> ${team.short_name}</p>
                        <p><strong>Headquarters:</strong> ${team.headquarters}</p>
                        <p><strong>Team Principal:</strong> ${team.team_principal}</p>
                    `;
                    teamList.appendChild(teamItem);
                });
            }

            function getFilteredTeams() {
                const searchQuery = document.querySelector('#search').value.toLowerCase();
                return allTeams.filter(team => {
                    return team.official_name.toLowerCase().includes(searchQuery) ||
                        team.short_name.toLowerCase().includes(searchQuery) ||
                        team.headquarters.toLowerCase().includes(searchQuery) ||
                        team.team_principal.toLowerCase().includes(searchQuery);
                });
            }

            function renderPagination() {
                const filteredTeams = getFilteredTeams();
                const totalPages = Math.ceil(filteredTeams.length / teamsPerPage);
                const pagination = document.querySelector('.pagination');
                pagination.innerHTML = '';

                for (let i = 1; i <= totalPages; i++) {
                    const pageBtn = document.createElement('button');
                    pageBtn.classList.add('page-btn');
                    pageBtn.innerText = i;
                    pageBtn.onclick = () => {
                        currentPage = i;
                        renderTeams();
                    };
                    pagination.appendChild(pageBtn);
                }
            }

            function filterTeams() {
                currentPage = 1;
                renderTeams();
                renderPagination();
            }
        </script>
    </head>
    <body>
        <header>
            <div class="container">
                <h1>Formula 1 Teams</h1>
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
        <section id="teams" class="section">
            <div class="container">
                <h2>Formula 1 Teams</h2>
                <p>Discover the top teams competing in Formula 1.</p>
                <input type="text" id="search" placeholder="Search by name, country, or stats" class="search-box">
                <div class="team-list"></div>
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
