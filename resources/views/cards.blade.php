<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile card-profiles with Dropdown</title>
    <style>
        .container-profile {
            max-width: 800px;
            margin: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .card-profile {
            max-width: 300px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            text-align: center;
            font-family: Arial, sans-serif;
            position: relative;
            overflow: visible; /* Ensure dropdown doesn't get cut off */
        }

        .card-profile img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            object-fit: cover; /* Ensures image fits within the circle */
        }

        .card-profile .info {
            margin-top: 15px;
            text-align: center;
        }

        .card-profile .info p {
            margin: 5px 0;
        }

        .dropdown-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: transparent; /* Remove background */
            color: black; /* Set color to black */
            border: none;
            cursor: pointer;
            outline: none;
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .dropdown-button:hover {
            color: #1E40AF; /* Optional: Change color on hover */
        }

        .dropdown-button svg {
            width: 24px;
            height: 24px;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            margin-top: 0.5rem;
            width: 11rem;
            z-index: 10;
            transform: translateX(-100%); /* Move the menu to the left of the button */
            right: 0; /* Align right edge with button */
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .dropdown-menu li {
            border-bottom: 1px solid #e5e7eb; /* Gray-100 */
        }

        .dropdown-menu li:last-child {
            border-bottom: none;
        }

        .dropdown-menu a {
            display: block;
            padding: 0.5rem 1rem;
            color: #374151; /* Gray-700 */
            text-decoration: none;
        }

        .dropdown-menu a:hover {
            background-color: #f3f4f6; /* Gray-100 */
        }

        .dark .dropdown-menu {
            background-color: #374151; /* Gray-700 */
        }

        .dark .dropdown-menu a {
            color: #d1d5db; /* Gray-200 */
        }

        .dark .dropdown-menu a:hover {
            background-color: #4b5563; /* Gray-600 */
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="container-profile">
        <div class="card-profile">
            <p><strong>ID:</strong> 12345</p>
            <img src="https://via.placeholder.com/100" alt="Profile Picture" loading="lazy">
            <h2>Username1</h2>
            <p><strong>Role:</strong> User Role1</p>
            <div class="info">
                <p><strong>Email:</strong> user1@example.com</p>
                <p><strong>Phone:</strong> 08123456789</p>
                <p><strong>Address:</strong> Jl. Contoh Alamat No. 123, Jakarta</p>
            </div>
            <button id="dropdownButton1" class="dropdown-button">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 8.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8 4.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8 12.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"/>
                </svg>
            </button>
            <div id="dropdown1" class="dropdown-menu">
                <ul>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Earnings</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sign out</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card-profile">
            <p><strong>ID:</strong> 12346</p>
            <img src="https://via.placeholder.com/100" alt="Profile Picture" loading="lazy">
            <h2>Username2</h2>
            <p><strong>Role:</strong> User Role2</p>
            <div class="info">
                <p><strong>Email:</strong> user2@example.com</p>
                <p><strong>Phone:</strong> 08123456788</p>
                <p><strong>Address:</strong> Jl. Contoh Alamat No. 124, Jakarta</p>
            </div>
            <button id="dropdownButton2" class="dropdown-button">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 8.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8 4.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8 12.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"/>
                </svg>
            </button>
            <div id="dropdown2" class="dropdown-menu">
                <ul>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Earnings</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sign out</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card-profile">
            <p><strong>ID:</strong> 12347</p>
            <img src="https://via.placeholder.com/100" alt="Profile Picture" loading="lazy">
            <h2>Username3</h2>
            <p><strong>Role:</strong> User Role3</p>
            <div class="info">
                <p><strong>Email:</strong> user3@example.com</p>
                <p><strong>Phone:</strong> 08123456787</p>
                <p><strong>Address:</strong> Jl. Contoh Alamat No. 125, Jakarta</p>
            </div>
            <button id="dropdownButton3" class="dropdown-button">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 8.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8 4.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8 12.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"/>
                </svg>
            </button>
            <div id="dropdown3" class="dropdown-menu">
                <ul>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Earnings</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sign out</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropdownButtons = document.querySelectorAll('.dropdown-button');
            const dropdownMenus = document.querySelectorAll('.dropdown-menu');

            dropdownButtons.forEach((button, index) => {
                button.addEventListener('click', function () {
                    const dropdownMenu = dropdownMenus[index];
                    dropdownMenu.style.top = `${button.offsetTop + button.offsetHeight}px`;
                    dropdownMenu.style.left = `${button.offsetLeft - dropdownMenu.offsetWidth}px`; // Adjust position to the left
                    dropdownMenu.classList.toggle('show');
                });
            });

            document.addEventListener('click', function (e) {
                dropdownButtons.forEach((button, index) => {
                    const dropdownMenu = dropdownMenus[index];
                    if (!button.contains(e.target) && !dropdownMenu.contains(e.target)) {
                        dropdownMenu.classList.remove('show');
                    }
                });
            });
        });
    </script>
</body>
</html>
