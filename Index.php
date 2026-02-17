<?php
// PHP code to handle the contact form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Basic validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $formStatus = "Please fill in all required fields.";
        $statusColor = "red";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $formStatus = "Please enter a valid email address.";
        $statusColor = "red";
    } else {
        // Simulate sending email (replace with actual mail function or service)
        $to = "info@easytech.com";
        $headers = "From: $email\r\nReply-To: $email\r\n";
        $fullMessage = "Name: $name\nEmail: $email\nSubject: $subject\n\nMessage:\n$message";

        if (mail($to, $subject, $fullMessage, $headers)) {
            $formStatus = "Thank you, your message has been sent.";
            $statusColor = "green";
        } else {
            $formStatus = "Sorry, there was an error sending your message. Please try again.";
            $statusColor = "red";
        }
    }
} else {
    $formStatus = "";
    $statusColor = "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>EasyTech Technologies Ltd</title>
<style>
  /* Reset */
  *, *::before, *::after {
    box-sizing: border-box;
    margin: 0; padding: 0;
  }
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    background: #fff;
    color: #111;
  }
  a {
    color: #3B69B8;
    text-decoration: none;
  }
  a:hover, a:focus {
    text-decoration: underline;
  }
  
  /* Container */
  .container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 1rem;
  }

  /* Header */
  header {
    position: sticky;
    top: 0; z-index: 1000;
    background: #fff;
    border-bottom: 1px solid #ededed;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
  }
  .nav-wrap {
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 64px;
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 1rem;
  }
  .logo {
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .logo img {
    height: 40px;
    width: auto;
    user-select: none;
  }
  nav {
    display: flex;
    gap: 28px;
  }
  nav a {
    font-weight: 600;
    font-size: 1rem;
    padding: 0.5rem 0;
    position: relative;
    color: #111;
  }
  nav a::after {
    content: '';
    position: absolute;
    bottom: -6px;
    left: 0;
    width: 0;
    height: 3px;
    background: #3B69B8;
    border-radius: 2px;
    transition: width 0.3s ease;
  }
  nav a:hover, nav a:focus, nav a.active {
    color: #3B69B8;
  }
  nav a:hover::after,
  nav a:focus::after,
  nav a.active::after {
    width: 100%;
  }
  .nav-toggle {
    display: none;
    font-size: 2rem;
    color: #3B69B8;
    background: none;
    border: none;
    cursor: pointer;
  }
  @media (max-width: 768px) {
    nav {
      position: absolute;
      top: 64px; left: 0; right: 0;
      background: white;
      flex-direction: column;
      gap: 0;
      box-shadow: 0 8px 24px rgba(0,0,0,0.1);
      border-radius: 0 0 10px 10px;
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s ease;
    }
    nav.show {
      max-height: 220px;
    }
    nav a {
      padding: 1rem 2rem;
      border-bottom: 1px solid #ddd;
    }
    .nav-toggle {
      display: block;
    }
  }

  /* Hero */
  .hero {
    max-width: 1140px;
    margin: 3rem auto 6rem;
    padding: 0 1rem;
    display: grid;
    grid-template-columns: 1fr 1fr;
    align-items: center;
    gap: 3rem;
  }
  .hero-logo img {
    max-width: 360px;
    width: 100%;
    user-select: none;
  }
  .hero-content h1 {
    font-size: 3rem;
    font-weight: 900;
    color: #0b1a3f;
    margin-bottom: 1.5rem;
    line-height: 1.1;
  }
  .hero-content p {
    font-size: 1.25rem;
    color: #3a4569;
    margin-bottom: 3rem;
    font-weight: 500;
  }
  .btn-primary {
    display: inline-block;
    background: #3B69B8;
    color: white;
    padding: 1rem 3rem;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1.1rem;
    box-shadow: 0 5px 20px rgba(59,105,184,.3);
    transition: background-color 0.3s ease;
  }
  .btn-primary:hover,
  .btn-primary:focus {
    background: #275fad;
  }
  @media (max-width: 900px) {
    .hero {
      grid-template-columns: 1fr;
      text-align: center;
    }
    .hero-logo {
      margin-bottom: 2rem;
    }
  }

  /* Section Titles */
  section h2 {
    text-align: center;
    font-weight: 700;
    font-size: 2.25rem;
    margin-bottom: 3rem;
    color: #3B69B8;
  }

  /* Cards Grid */
  .grid-3 {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2.5rem;
    max-width: 1100px;
    margin: 0 auto;
  }
  .card {
    background: #f6f9fc;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.05);
    transition: box-shadow 0.3s ease;
  }
  .card:hover,
  .card:focus {
    box-shadow: 0 14px 40px rgba(0,0,0,0.12);
  }
  .card h3 {
    margin-bottom: 1rem;
    font-weight: 700;
    color: #092147;
    font-size: 1.2rem;
  }
  .card ul {
    list-style: disc inside;
    color: #4b5f7d;
  }
  .card ul li {
    margin-bottom: 0.7rem;
    font-weight: 500;
  }

  /* Footer */
  footer {
    background-color: #0b1a3f;
    color: #ccc;
    text-align: center;
    padding: 2rem 1rem;
    font-weight: 500;
  }
</style>
</head>
<body>

<header>
  <div class="nav-wrap">
    <div class="logo" aria-label="EasyTech logo">
      <img src="logo2.jpeg" alt="EasyTech Logo" />
      <span>EasyTech</span>
    </div>
    <button class="nav-toggle" id="navToggle" aria-label="Toggle menu">&#9776;</button>
    <nav id="mainNav" class="nav-links">
      <a href="#home" class="active">Home</a>
      <a href="#about">About</a>
      <a href="#services">Services</a>
      <a href="#quality">Quality & Innovation</a>
      <a href="#support">Client Support</a>
      <a href="#declaration">Declaration</a>
      <a href="#contact">Contact</a>
    </nav>
  </div>
</header>

<main>
  <section class="hero" id="home" aria-label="Hero section">
    <div class="hero-content container">
      <h1>Innovative Technology Solutions for Malawi and Beyond</h1>
      <p>EasyTech Technologies Ltd. delivers integrated, forward-thinking digital services for businesses and public sector clients.</p>
      <a href="#contact" class="btn-primary">Request a Quote</a>
    </div>
    <div class="hero-logo container">
      <img src="logo2.jpeg" alt="EasyTech Logo" />
    </div>
  </section>

  <section id="about" aria-label="About section">
    <h2>About EasyTech</h2>
    <div class="grid-3 container">
      <article class="card" tabindex="0">
        <h3>Company Overview</h3>
        <ul>
          <li>Deliver innovative and professional services throughout Malawi.</li>
          <li>Skilled team delivering projects on time and within budget.</li>
          <li>Quality-focused cooperative client approach.</li>
        </ul>
      </article>
      <article class="card" tabindex="0">
        <h3>Mission</h3>
        <ul>
          <li>Empower communities and businesses through tech solutions.</li>
          <li>Boost efficiency, connectivity, and digital transformation.</li>
          <li>Exceptional IT infrastructure and consulting services.</li>
        </ul>
      </article>
      <article class="card" tabindex="0">
        <h3>Vision</h3>
        <ul>
          <li>Shape a future where technology empowers all.</li>
          <li>Drive innovation transforming how people live and work.</li>
          <li>Build smart, scalable, sustainable solutions.</li>
        </ul>
      </article>
    </div>
  </section>

  <section id="services" aria-label="Services section">
    <h2>Key Services & Expertise</h2>
    <div class="grid-3 container">
      <article class="card" tabindex="0">
        <h3>Software & Data</h3>
        <ul>
          <li>Custom software development</li>
          <li>Web & mobile applications</li>
          <li>Data analytics & BI</li>
          <li>AI & ML integration</li>
        </ul>
      </article>
      <article class="card" tabindex="0">
        <h3>Infrastructure & Security</h3>
        <ul>
          <li>Cloud setup, migration & management</li>
          <li>Network design & optimization</li>
          <li>Cybersecurity solutions</li>
          <li>Remote workspace tools</li>
        </ul>
      </article>
      <article class="card" tabindex="0">
        <h3>Systems & Hardware</h3>
        <ul>
          <li>IoT smart systems & automation</li>
          <li>Inverter & UPS installation</li>
          <li>CCTV & access control</li>
          <li>IT hardware & servicing</li>
        </ul>
      </article>
    </div>
  </section>

  <section id="quality" aria-label="Quality & innovation section" class="section-alt">
    <h2>Quality & Innovation</h2>
    <div class="grid-3 container">
      <article class="card" tabindex="0">
        <h3>Quality Assurance</h3>
        <ul>
          <li>Strict quality, reliability, and security standards.</li>
          <li>Rigorous control protocols to exceed expectations.</li>
          <li>Continuous improvement with client feedback.</li>
        </ul>
      </article>
      <article class="card" tabindex="0">
        <h3>Innovation & Technology</h3>
        <ul>
          <li>Adopting emerging tech strategically.</li>
          <li>Delivering scalable, future-ready systems.</li>
          <li>Driving client growth & competitive edge.</li>
        </ul>
      </article>
    </div>
  </section>

  <section id="support" aria-label="Client support section">
    <h2>Client Engagement & Support</h2>
    <div class="grid-3 container">
      <article class="card" tabindex="0">
        <h3>Customer Service</h3>
        <ul>
          <li>Proactive and personalized communication.</li>
          <li>Solutions aligned with client goals.</li>
          <li>Respectful and timely assistance.</li>
        </ul>
      </article>
      <article class="card" tabindex="0">
        <h3>Support Channels</h3>
        <ul>
          <li>Email, phone, live chat, support portal.</li>
          <li>24-hour response goal.</li>
          <li>Priority for urgent issues.</li>
        </ul>
      </article>
      <article class="card" tabindex="0">
        <h3>Continuous Improvement</h3>
        <ul>
          <li>Collect client feedback regularly.</li>
          <li>Improve services continually.</li>
          <li>Elevate client experience.</li>
        </ul>
      </article>
    </div>
  </section>

  <section id="declaration" aria-label="Declaration & certification" class="section-alt">
    <h2>Declaration and Certification</h2>
    <article class="card" tabindex="0" style="max-width: 900px; margin: 0 auto;">
      <ul>
        <li>Information presented is accurate and current.</li>
        <li>Equal opportunity and ethical practices upheld.</li>
        <li>No discrimination on any protected basis.</li>
        <li>Recruitment and services based on merit and integrity.</li>
      </ul>
    </article>
  </section>

  <section id="contact" aria-label="Contact section">
    <h2>Contact Us</h2>
    <div class="contact-container container">
      <section class="contact-info" aria-label="Company information">
        <ul>
          <li><strong>Company:</strong> EasyTech Technologies Ltd</li>
          <li><strong>Location:</strong> Balaka</li>
          <li><strong>Email:</strong> <a href="mailto:info@easytech.com">info@easytech.com</a></li>
          <li><strong>Phone:</strong> <a href="tel:+265999988990">(+265) 999988990</a></li>
          <li><strong>P.B:</strong> 37, LL</li>
        </ul>
      </section>
      <form id="contactForm" method="post" action="" aria-label="Contact form" novalidate>
        <label for="name">Name*</label>
        <input type="text" id="name" name="name" required />

        <label for="email">Email*</label>
        <input type="email" id="email" name="email" required />

        <label for="subject">Subject*</label>
        <input type="text" id="subject" name="subject" required />

        <label for="message">Message*</label>
        <textarea id="message" name="message" rows="5" required></textarea>

        <button type="submit">Send Message</button>

        <p id="formStatus" role="alert" aria-live="polite" style="margin-top:1rem; color: <?php echo $statusColor; ?>;"><?php echo $formStatus; ?></p>
      </form>
    </div>
  </section>
</main>

<footer>
  &copy; 2025 EasyTech Technologies Ltd. All rights reserved.
</footer>

<script>
  // Toggle mobile navigation menu
  const navToggle = document.getElementById('navToggle');
  const mainNav = document.getElementById('mainNav');
  navToggle.addEventListener('click', () => mainNav.classList.toggle('show'));
</script>

</body>
</html>
