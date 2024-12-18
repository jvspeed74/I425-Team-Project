<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formula 1 Events</title>
        <link rel="stylesheet" href="css/global.css">
        <script>
            let allEvents = [];
            const eventsPerPage = 5;
            let currentPage = 1;

            document.addEventListener("DOMContentLoaded", function() {
                fetchEvents();
                document.querySelector('#search').addEventListener('input', filterEvents);
            });

            function fetchEvents() {
                fetch('http://localhost:8080/events')
                    .then(response => response.json())
                    .then(events => {
                    allEvents = events;
                    renderEvents();
                    renderPagination();
                })
                .catch(error => console.error('Error fetching events:', error));
            }

            function renderEvents() {
                const eventList = document.querySelector('.event-list');
                eventList.innerHTML = '';

                const filteredEvents = getFilteredEvents();

                const startIndex = (currentPage - 1) * eventsPerPage;
                const endIndex = startIndex + eventsPerPage;
                const eventsToDisplay = filteredEvents.slice(startIndex, endIndex);

                eventsToDisplay.forEach(event => {
                    const eventItem = document.createElement('div');
                    eventItem.classList.add('event-item');
                    eventItem.innerHTML = `
                        <h3>${event.title}</h3>
                        <p><strong>Date:</strong> ${event.scheduled_date}</p>
                        <p><strong>Status:</strong> ${event.status}</p>
                    `;
                    eventList.appendChild(eventItem);
                });
            }

            function getFilteredEvents() {
                const searchQuery = document.querySelector('#search').value.toLowerCase();
                return allEvents.filter(event => {
                    return event.title.toLowerCase().includes(searchQuery) ||
                        event.status.toLowerCase().includes(searchQuery);
                });
            }

            function renderPagination() {
                const filteredEvents = getFilteredEvents();
                const totalPages = Math.ceil(filteredEvents.length / eventsPerPage);
                const pagination = document.querySelector('.pagination');
                pagination.innerHTML = '';

                for (let i = 1; i <= totalPages; i++) {
                    const pageBtn = document.createElement('button');
                    pageBtn.classList.add('page-btn');
                    pageBtn.innerText = i;
                    pageBtn.onclick = () => {
                        currentPage = i;
                        renderEvents();
                    };
                    pagination.appendChild(pageBtn);
                }
            }

            function filterEvents() {
                currentPage = 1;
                renderEvents();
                renderPagination();
            }
        </script>
    </head>
    <body>
        <header>
            <div class="container">
                <h1>Formula 1 Events</h1>
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
        <section id="events" class="section">
            <div class="container">
                <h2>Formula 1 Events</h2>
                <p>Stay up to date with the latest Formula 1 events around the world.</p>
                <input type="text" id="search" placeholder="Search events..." class="search-box">
                <div class="event-list"></div>
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
