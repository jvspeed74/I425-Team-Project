<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>F1 Center</title>
        <link rel="stylesheet" href="css/f1.css">
    </head>
    <body>
        <header>
            <div class="container">
                <h1>F1 Center</h1>
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
        <section id="hero">
            <div class="hero-container">
                <div class="slide">
                    <img src="images/racing.jpg" class="hero-image" >
                </div>
                <div class="slide">
                    <img src="images/monaco.jpg" class="hero-image" >
                </div>
                <div class="slide">
                    <img src="images/betterracing.jpg" class="hero-image" >
                </div>
                <div class="slide">
                    <img src="images/cooltrack.jpg" class="hero-image" >
                </div>
            </div>
        </section>
        <section id="tracks" class="section">
            <div class="container">
                <h2>F1 Tracks</h2>
                <p>Discover iconic F1 race tracks around the world.</p>
                <div class="track-list">
                    <div class="track-item">
                        <img src="images/silverstone.jpg" alt="Silverstone Circuit">
                        <h3>Silverstone Circuit</h3>
                        <p><strong>Location:</strong> Northamptonshire, UK</p>
                        <p>The iconic British Grand Prix is a must-watch!</p>
                    </div>
                    <div class="track-item">
                        <img src="images/monaco.jpg" alt="Monaco Grand Prix">
                        <h3>Monaco Grand Prix</h3>
                        <p><strong>Location:</strong> Monte Carlo, Monaco</p>
                        <p>One of the most prestigious and historic F1 races.</p>
                    </div>
                    <div class="track-item">
                        <img src="images/suzuka.jpg" alt="Suzuka Circuit">
                        <h3>Suzuka Circuit</h3>
                        <p><strong>Location:</strong> Suzuka, Japan</p>
                        <p>Famous for its challenging and fast layout.</p>
                    </div>
                </div>
                <a href="/tracksPage" class="btn">See All Tracks</a>
            </div>
        </section>
        <section id="drivers" class="section">
            <div class="container">
                <h2>Meet the F1 Drivers</h2>
                <p>Get to know the stars of Formula 1!</p>
                <div class="driver-list">
                    <div class="driver-item">
                        <img src="images/lewis-hamilton.jpg" alt="Lewis Hamilton">
                        <h3>Lewis Hamilton</h3>
                        <p><strong>Team:</strong> Mercedes</p>
                        <p><strong>Nationality:</strong> British</p>
                        <p><strong>World Championships:</strong> 7</p>
                    </div>
                    <div class="driver-item">
                        <img src="images/max-verstappen.jpg" alt="Max Verstappen">
                        <h3>Max Verstappen</h3>
                        <p><strong>Team:</strong> Red Bull Racing</p>
                        <p><strong>Nationality:</strong> Dutch</p>
                        <p><strong>World Championships:</strong> 2</p>
                    </div>
                    <div class="driver-item">
                        <img src="images/charles-leclerc.jpg" alt="Charles Leclerc">
                        <h3>Charles Leclerc</h3>
                        <p><strong>Team:</strong> Ferrari</p>
                        <p><strong>Nationality:</strong> Monegasque</p>
                        <p><strong>World Championships:</strong> 0</p>
                    </div>
                </div>
                <a href="/driversPage" class="btn">See All Drivers</a>
            </div>
        </section>
        <footer>
            <div class="container">
                <p>&copy; 2024 F1 Center. All Rights Reserved.</p>
            </div>
        </footer>
        <script>
            window.onload = function() {
                const container = document.querySelector('.hero-container');
                const slides = document.querySelectorAll('.slide');

                let currentIndex = 0;

                function nextSlide() {
                    currentIndex = (currentIndex + 1) % slides.length;
                    container.style.transform = `translateX(-${currentIndex * 100}%)`;
                }
                setInterval(nextSlide, 7000);
            };
        </script>
    </body>
</html>
