// data.js

// Dummy data
const dummyData = {
    bannerSrc: "../public/images/linkedinbanner.webp",
    photoSrc: "../public/images/paper.id.webp",
    name: "Paper.id",
    tagline: "Streamline Your Business Invoicing and Payments Effortlessly with Paper.id and #SwipeUpYourLife!",
    location: "New York, USA",
    contact: "Contact info",
    description: "Sejak 2016, Paper.id telah merevolusi invoicing dan pembayaran B2B dengan solusi digital untuk bisnis dari UKM hingga enterprise. Paper.id mengurangi risiko administratif, proses manual, serta keterlambatan pembayaran, sehingga keputusan keuangan dapat dibuat lebih cepat dan akurat lewat fitur-fitur otomatisasi penagihan, pembayaran, dan laporan keuangan sederhana agar bisnis dapat fokus untuk terus bertumbuh."
};

// Function to insert dummy data into HTML
function insertDummyData() {
    document.querySelector('.profile-banner img').src = dummyData.bannerSrc;
    document.querySelector('.profile-photo img').src = dummyData.photoSrc;
    document.querySelector('.profile-name').innerHTML = dummyData.name;
    document.querySelector('.profile-tagline').textContent = dummyData.tagline;
    document.querySelector('.profile-location').innerHTML = dummyData.location + ' • <a href="#">' + dummyData.contact + '</a>';
    document.querySelector('.company-desc').textContent = dummyData.description;
}

// Call the function after the DOM is fully loaded
document.addEventListener('DOMContentLoaded', insertDummyData);


// Job vacancy data to be inserted dynamically
const jobvacancyData = [
    {
        posisi: "Data Analyst",
        deskripsi: "Responsible for analyzing and interpreting complex data sets to help companies make informed business decisions.",
        jenisJob: "Internship",
        jenisLokasi: "On-site",
        image: "../images/paper.id.webp"
    },
    {
        posisi: "Content Creator",
        deskripsi: "Creates engaging and relevant content for various platforms, including social media, blogs, and websites.",
        jenisJob: "Part-time",
        jenisLokasi: "Hybrid",
        image: "../images/paper.id.webp"
    },
    {
        posisi: "Backend Developer",
        deskripsi: "Develops and maintains the server-side logic, databases, and APIs for web applications.",
        jenisJob: "Full-time",
        jenisLokasi: "Remote",
        image: "../images/paper.id.webp"
    },
    {
        posisi: "Full-stack Mobile Developer",
        deskripsi: "Works on both the front-end and back-end of mobile applications, ensuring seamless user experiences.",
        jenisJob: "Internship",
        jenisLokasi: "On-site",
        image: "../images/paper.id.webp"
    }
];

// Function to generate job vacancy cards
function generateJobVacancyCards() {
    const container = document.getElementById('jobvacancy-cards');

    jobvacancyData.forEach(item => {
        const card = document.createElement('div');
        card.className = 'jobvacancy-card';

        card.innerHTML = `
            <img src="${item.image}" alt="${item.posisi}">
            <div class="jobvacancy-info">
                <a href="#">${item.posisi}</a>
                <p>${item.deskripsi}</p>
                <p>${item.jenisJob}<span> • ${item.jenisLokasi}</p>
            </div>
        `;

        container.appendChild(card);
    });
}

// Run the function to generate cards on page load
window.onload = generateJobVacancyCards;
