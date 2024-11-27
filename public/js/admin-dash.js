// SIDEBAR DROPDOWN
const allDropdown = document.querySelectorAll("#sidebar .side-dropdown");
const sidebar = document.getElementById("sidebar");

allDropdown.forEach((item) => {
    const a = item.parentElement.querySelector("a:first-child");
    a.addEventListener("click", function (e) {
        e.preventDefault();

        if (!this.classList.contains("active")) {
            allDropdown.forEach((i) => {
                const aLink = i.parentElement.querySelector("a:first-child");

                aLink.classList.remove("active");
                i.classList.remove("show");
            });
        }

        this.classList.toggle("active");
        item.classList.toggle("show");
    });
});

// function setActiveLink(link, targetUrl) {
// 	var currentUrl = window.location.pathname;

// 	// Check if the target URL is the same as the current URL
// 	if (currentUrl !== targetUrl) {
// 		// openModal();
// 		// Remove active class from all links
// 		var links = document.querySelectorAll('a:first-child');
// 		links.forEach(function(element) {
// 			element.classList.remove('active');
// 		});

// 		// Add active class to the clicked link
// 		link.classList.add('active');

// 	} else {
// 		// If target URL is same as current URL, prevent modal opening
// 		event.preventDefault();
// 		console.log("Already on the same page.");
// 	}
// }

// Check and set active link on page load
document.addEventListener("DOMContentLoaded", function () {
    var currentPath = window.location.pathname;
    console.log(currentPath);
    var pathSegments = currentPath
        .split("/")
        .filter((segment) => segment !== "");
    var firstSegment = "/" + pathSegments[0];
    console.log(firstSegment);
    var links = document.querySelectorAll("a:first-child");

    links.forEach(function (link) {
        link.classList.remove("active-side-dropdown");
        if (link.getAttribute("href") === firstSegment) {
            link.classList.add("active-side-dropdown");
            // link.parentNode.classList.add('active-side-dropdown');
        }
    });

    // Adding active class for dropdown parents
    var dropdownLinks = document.querySelectorAll(".side-dropdown a");

    dropdownLinks.forEach(function (link) {
        if (link.getAttribute("href") === firstSegment) {
            var parentLink = link.closest("ul").previousElementSibling;
            if (parentLink) {
                parentLink.classList.add("active-side-dropdown");
                // parentLink.parentNode.classList.add('active-side-dropdown');
            }
        }
    });
});

// SIDEBAR COLLAPSE
const toggleSidebar = document.querySelector("nav .toggle-sidebar");
const allSideDivider = document.querySelectorAll("#sidebar .divider");

if (sidebar) {
    if (sidebar.classList.contains("hide")) {
        allSideDivider.forEach((item) => {
            item.textContent = "-";
        });
        allDropdown.forEach((item) => {
            const a = item.parentElement.querySelector("a:first-child");
            a.classList.remove("active");
            item.classList.remove("show");
        });
    } else {
        allSideDivider.forEach((item) => {
            item.textContent = item.dataset.text;
        });
    }
}

// if (toggleSidebar) {
//     toggleSidebar.addEventListener("click", function () {
//         sidebar.classList.toggle("hide");
//         const mainContent = document.getElementById("maincontent");

//         if (sidebar.classList.contains("hide")) {
//             mainContent.classList.add("active");
//             allSideDivider.forEach((item) => {
//                 item.textContent = "-";
//             });

//             allDropdown.forEach((item) => {
//                 const a = item.parentElement.querySelector("a:first-child");
//                 a.classList.remove("active");
//                 item.classList.remove("show");
//             });
//         } else {
//             mainContent.classList.remove("active");
//             allSideDivider.forEach((item) => {
//                 item.textContent = item.dataset.text;
//             });
//         }
//     });
// }

if (toggleSidebar) {
    // Function to handle the sidebar toggle logic
    function toggleSidebarHandler() {
        sidebar.classList.toggle("hide");
        const mainContent = document.getElementById("maincontent");

        if (sidebar.classList.contains("hide")) {
            mainContent.classList.add("active");
            allSideDivider.forEach((item) => {
                item.textContent = "-";
            });

            allDropdown.forEach((item) => {
                const a = item.parentElement.querySelector("a:first-child");
                a.classList.remove("active");
                item.classList.remove("show");
            });
        } else {
            mainContent.classList.remove("active");
            allSideDivider.forEach((item) => {
                item.textContent = item.dataset.text;
            });
        }
    }

    // Add event listener to the toggle button
    toggleSidebar.addEventListener("click", toggleSidebarHandler);

    // Check if the screen is a mobile size and trigger the sidebar toggle
    if (window.innerWidth <= 768) {
        // Adjust the width as needed for mobile screens
        toggleSidebarHandler();
    }

    // Optional: Listen for window resize events to toggle based on resizing to/from mobile size
    window.addEventListener("resize", function () {
        if (window.innerWidth <= 768 && !sidebar.classList.contains("hide")) {
            toggleSidebarHandler();
        } else if (
            window.innerWidth > 768 &&
            sidebar.classList.contains("hide")
        ) {
            toggleSidebarHandler();
        }
    });
}

if (sidebar) {
    sidebar.addEventListener("mouseleave", function () {
        if (this.classList.contains("hide")) {
            allDropdown.forEach((item) => {
                const a = item.parentElement.querySelector("a:first-child");
                a.classList.remove("active");
                item.classList.remove("show");
            });
            allSideDivider.forEach((item) => {
                item.textContent = "-";
            });
        }
    });

    sidebar.addEventListener("mouseenter", function () {
        if (this.classList.contains("hide")) {
            allDropdown.forEach((item) => {
                const a = item.parentElement.querySelector("a:first-child");
                a.classList.remove("active");
                item.classList.remove("show");
            });
            allSideDivider.forEach((item) => {
                item.textContent = item.dataset.text;
            });
        }
    });
}

// PROFILE DROPDOWN
const profile = document.querySelector("nav .profile");
if (profile) {
    const imgProfile = profile.querySelector("img");
    // const imgProfile2 = document.getElementsByClassName('brandLogoDiv');
    const dropdownProfile = profile.querySelector(".profile-link");

    // imgProfile2.addEventListener('click', function () {
    // 	dropdownProfile.classList.toggle('show');
    // })

    function openProfile() {
        const profile = document.querySelector("nav .profile");
        const dropdownProfile = profile.querySelector(".profile-link");
        dropdownProfile.classList.toggle("show");
    }
}

// MENU
const allMenu = document.querySelectorAll("main .content-data .head .menu");

allMenu.forEach((item) => {
    const icon = item.querySelector(".icon");
    const menuLink = item.querySelector(".menu-link");

    icon.addEventListener("click", function () {
        menuLink.classList.toggle("show");
    });
});

window.addEventListener("click", function (e) {
    // if(e.target !== imgProfile) {
    // 	if(e.target !== dropdownProfile) {
    // 		if(dropdownProfile.classList.contains('show')) {
    // 			dropdownProfile.classList.remove('show');
    // 		}
    // 	}
    // }

    allMenu.forEach((item) => {
        const icon = item.querySelector(".icon");
        const menuLink = item.querySelector(".menu-link");

        if (e.target !== icon) {
            if (e.target !== menuLink) {
                if (menuLink.classList.contains("show")) {
                    menuLink.classList.remove("show");
                }
            }
        }
    });
});

// PROGRESSBAR
const allProgress = document.querySelectorAll("main .card .progress");

allProgress.forEach((item) => {
    item.style.setProperty("--value", item.dataset.value);
});

// APEXCHART
var options = {
    series: [
        {
            name: "series1",
            data: [31, 40, 28, 51, 42, 109, 100],
        },
        {
            name: "series2",
            data: [11, 32, 45, 32, 34, 52, 41],
        },
    ],
    chart: {
        height: 350,
        type: "area",
    },
    dataLabels: {
        enabled: false,
    },
    stroke: {
        curve: "smooth",
    },
    xaxis: {
        type: "datetime",
        categories: [
            "2018-09-19T00:00:00.000Z",
            "2018-09-19T01:30:00.000Z",
            "2018-09-19T02:30:00.000Z",
            "2018-09-19T03:30:00.000Z",
            "2018-09-19T04:30:00.000Z",
            "2018-09-19T05:30:00.000Z",
            "2018-09-19T06:30:00.000Z",
        ],
    },
    tooltip: {
        x: {
            format: "dd/MM/yy HH:mm",
        },
    },
};

// var chart = new ApexCharts(document.querySelector("#chart"), options);
// chart.render();

// chat screen js
$("#contacts .item").click(function () {
    $(this).parents("#contacts").addClass("hidden");
    $("#content-chart").addClass("active");
});

$("#back").click(function (e) {
    e.preventDefault();
    $("#contacts").removeClass("hidden");
    $("#content-chart").removeClass("active");
});

function openMsgDiv() {
    $("#chatScreen").show();
    $(".bio-div").hide();
    $("#chatScreen input.form-control").focus();
}

// // Hide chat screen when close button is clicked
$("#closeChat").click(function (e) {
    e.preventDefault();
    $("#chatScreen").hide();
    $(".bio-div").show();
});

function openSetting() {
    $("#settings").show();
    $("#contacts").hide();
    $("#content-chart").hide();
    $("#people-link").removeClass("active");
    $("#settings-link").addClass("active");
}
function openPeopleList() {
    $("#settings").hide();
    $("#contacts").show();
    $("#content-chart").show();
    $("#settings-link").removeClass("active");
    $("#people-link").addClass("active");
}

document.addEventListener("DOMContentLoaded", function () {
    if (
        window.location.pathname === "/chat" ||
        window.location.pathname === "/chat/"
    ) {
        document.body.id = "userPage";
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const emojiPicker = document.getElementById('emojiPicker');
    const emojiButton = document.getElementById('emojiButton');
    const messageInput = document.getElementById('messageInput');

    // Toggle emoji picker visibility
    emojiButton.addEventListener('click', () => {
        if (emojiPicker.style.display === 'none' || !emojiPicker.style.display) {
            emojiPicker.style.display = 'block';
        } else {
            emojiPicker.style.display = 'none';
        }
    });

    // Add emoji to input when selected
    emojiPicker.addEventListener('emoji-click', (event) => {
        messageInput.value += event.detail.unicode;
        emojiPicker.style.display = 'none';
    });

    // Handle file attachment
    document.getElementById('fileInput').addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (file) {
            console.log('Attached file:', file.name);
            // Add your file upload logic here
        }
    });
});

