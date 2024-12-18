<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formula 1 Tracks</title>
        <link rel="stylesheet" href="css/global.css">
        <script>
            let allTracks = [];
            let currentPage = 1;
            const tracksPerPage = 5;

            document.addEventListener("DOMContentLoaded", function() {
                fetchTracks();
                document.querySelector('#search').addEventListener('input', filterTracks);
            });

            function fetchTracks() {
                fetch('http://localhost:8080/tracks')
                    .then(response => response.json())
                    .then(tracks => {
                    allTracks = tracks;
                    renderTracks();
                    renderPagination();
                })
                .catch(error => console.error('Error fetching tracks:', error));
            }

            function renderTracks() {
                const trackList = document.querySelector('.track-list');
                trackList.innerHTML = '';

                const filteredTracks = getFilteredTracks();

                const startIndex = (currentPage - 1) * tracksPerPage;
                const endIndex = startIndex + tracksPerPage;
                const tracksToDisplay = filteredTracks.slice(startIndex, endIndex);

                tracksToDisplay.forEach(track => {
                    const trackItem = document.createElement('div');
                    trackItem.classList.add('track-item');
                    trackItem.innerHTML = `
                        <h3>${track.name}</h3>
                        <p><strong>Length:</strong> ${track.length_km} km</p>
                        <p><strong>Continent:</strong> ${track.continent}</p>
                        <p><strong>Description:</strong> ${track.description}</p>
                    `;
                    trackList.appendChild(trackItem);
                });
            }

            function getFilteredTracks() {
                const searchQuery = document.querySelector('#search').value.toLowerCase();
                return allTracks.filter(track => {
                    return track.name.toLowerCase().includes(searchQuery) ||
                        track.continent.toLowerCase().includes(searchQuery) ||
                        track.description.toLowerCase().includes(searchQuery);
                });
            }

            function renderPagination() {
                const filteredTracks = getFilteredTracks();
                const totalPages = Math.ceil(filteredTracks.length / tracksPerPage);
                const pagination = document.querySelector('.pagination');
                pagination.innerHTML = '';

                for (let i = 1; i <= totalPages; i++) {
                    const pageBtn = document.createElement('button');
                    pageBtn.classList.add('page-btn');
                    pageBtn.innerText = i;
                    pageBtn.onclick = () => {
                        currentPage = i;
                        renderTracks();
                    };
                    pagination.appendChild(pageBtn);
                }
            }

            function filterTracks() {
                currentPage = 1;
                renderTracks();
                renderPagination();
            }
        </script>
    </head>
    <body>
        <header>
            <div class="container">
                <h1>Formula 1 Tracks</h1>
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
        <section id="tracks" class="section">
            <div class="container">
                <h2>F1 Tracks</h2>
                <p>Explore the iconic Formula 1 tracks from around the world.</p>
                <input type="text" id="search" placeholder="Search tracks..." class="search-box">
                <div class="track-list"></div>
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
