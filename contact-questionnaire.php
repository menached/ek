<?php
// Settings
$recipient = 'info@devopsandplatforms.com'; // Change to your target email
$sent = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = [
        'name' => trim($_POST['name'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'phone' => trim($_POST['phone'] ?? ''),
        'address' => trim($_POST['address'] ?? ''),
        'project-type' => trim($_POST['project-type'] ?? ''),
        'main-priority' => trim($_POST['main-priority'] ?? ''),
        'timeline' => trim($_POST['timeline'] ?? ''),
        'budget' => trim($_POST['budget'] ?? ''),
        'how-heard' => trim($_POST['how-heard'] ?? ''),
        'details' => trim($_POST['details'] ?? ''),
        'best-contact' => trim($_POST['best-contact'] ?? ''),
    ];

    if (!$fields['name'] || !$fields['email'] || !$fields['phone'] || !$fields['project-type'] || !$fields['main-priority']) {
        $error = 'Please fill out all required fields.';
    } else if (!filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        $subject = "New Project Questionnaire from " . $fields['name'];
        $body = "A new client has submitted a project questionnaire:\n\n";
        foreach ($fields as $label => $value) {
            $body .= ucfirst(str_replace('-', ' ', $label)) . ": " . $value . "\n";
        }

        $headers = "From: " . $fields['email'] . "\r\n" .
                   "Reply-To: " . $fields['email'] . "\r\n";
        $sent = mail($recipient, $subject, $body, $headers);
        if (!$sent) {
            $error = 'Sorry, there was an issue sending your message. Please try again.';
        }
    }
}
?>
<section class="ek-form-section">
  <h2 style="font-family: 'Marvel', Arial, sans-serif; font-size: 2rem; text-align: center; margin-bottom: 0.4em; color: #31445b; letter-spacing: 1px;">Custom Project Questionnaire</h2>
  <p style="text-align:center; color:#5e7753; margin-bottom:1.5em; font-size:1.07em;">Tell us about your vision. We respond quickly to every inquiry.</p>
  <?php if ($sent): ?>
    <div class="msg">Thank you! Your questionnaire has been sent.</div>
  <?php elseif ($error): ?>
    <div class="msg error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form method="POST" autocomplete="on" novalidate>
    <label for="name">Full Name *</label>
    <input type="text" id="name" name="name" placeholder="Your full name" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">

    <label for="email">Email *</label>
    <input type="email" id="email" name="email" placeholder="you@email.com" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

    <label for="phone">Phone *</label>
    <input type="tel" id="phone" name="phone" placeholder="(xxx) xxx-xxxx" required value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">

    <label for="address">Project Address (or City & ZIP)</label>
    <input type="text" id="address" name="address" placeholder="e.g. 123 Main St, City, ZIP" value="<?= htmlspecialchars($_POST['address'] ?? '') ?>">

    <label for="project-type">What type of project? *</label>
    <select id="project-type" name="project-type" required>
      <option value="">Select one</option>
      <option<?= (@$_POST['project-type']=='New Home Construction')?' selected':'' ?>>New Home Construction</option>
      <option<?= (@$_POST['project-type']=='Remodel / Renovation')?' selected':'' ?>>Remodel / Renovation</option>
      <option<?= (@$_POST['project-type']=='Addition')?' selected':'' ?>>Addition</option>
      <option<?= (@$_POST['project-type']=='ADU / Guest House')?' selected':'' ?>>ADU / Guest House</option>
      <option<?= (@$_POST['project-type']=='Kitchen Remodel')?' selected':'' ?>>Kitchen Remodel</option>
      <option<?= (@$_POST['project-type']=='Bathroom Remodel')?' selected':'' ?>>Bathroom Remodel</option>
      <option<?= (@$_POST['project-type']=='Outdoor Living / Deck / Pergola')?' selected':'' ?>>Outdoor Living / Deck / Pergola</option>
      <option<?= (@$_POST['project-type']=='Structural Repair')?' selected':'' ?>>Structural Repair</option>
      <option<?= (@$_POST['project-type']=='Other')?' selected':'' ?>>Other</option>
    </select>

    <label for="main-priority">Main Priority *</label>
    <select id="main-priority" name="main-priority" required>
      <option value="">Select one</option>
      <option<?= (@$_POST['main-priority']=='Luxury Craftsmanship')?' selected':'' ?>>Luxury Craftsmanship</option>
      <option<?= (@$_POST['main-priority']=='Quick Completion')?' selected':'' ?>>Quick Completion</option>
      <option<?= (@$_POST['main-priority']=='Affordable Budget')?' selected':'' ?>>Affordable Budget</option>
      <option<?= (@$_POST['main-priority']=='Eco-Friendly / Green Build')?' selected':'' ?>>Eco-Friendly / Green Build</option>
      <option<?= (@$_POST['main-priority']=='Custom Design Features')?' selected':'' ?>>Custom Design Features</option>
      <option<?= (@$_POST['main-priority']=='Not Sure')?' selected':'' ?>>Not Sure</option>
    </select>

    <label for="timeline">Desired Project Timeline</label>
    <input type="text" id="timeline" name="timeline" placeholder="e.g. ASAP, Summer 2025, Flexible..." value="<?= htmlspecialchars($_POST['timeline'] ?? '') ?>">

    <label for="budget">Estimated Budget Range</label>
    <input type="text" id="budget" name="budget" placeholder="$150,000 – $300,000, not sure, etc." value="<?= htmlspecialchars($_POST['budget'] ?? '') ?>">

    <label for="how-heard">How did you hear about EK Construction?</label>
    <select id="how-heard" name="how-heard">
      <option value="">Select one</option>
      <option<?= (@$_POST['how-heard']=='Referral / Friend')?' selected':'' ?>>Referral / Friend</option>
      <option<?= (@$_POST['how-heard']=='Google')?' selected':'' ?>>Google</option>
      <option<?= (@$_POST['how-heard']=='Houzz')?' selected':'' ?>>Houzz</option>
      <option<?= (@$_POST['how-heard']=='Social Media')?' selected':'' ?>>Social Media</option>
      <option<?= (@$_POST['how-heard']=='Repeat Client')?' selected':'' ?>>Repeat Client</option>
      <option<?= (@$_POST['how-heard']=='Other')?' selected':'' ?>>Other</option>
    </select>

    <label for="details">Tell us about your vision and any must-haves</label>
    <textarea id="details" name="details" rows="4" placeholder="Let us know what matters most to you in this project."><?= htmlspecialchars($_POST['details'] ?? '') ?></textarea>

    <label for="best-contact">Best way/time to contact you</label>
    <input type="text" id="best-contact" name="best-contact" placeholder="Call, email, mornings, evenings, etc." value="<?= htmlspecialchars($_POST['best-contact'] ?? '') ?>">

    <button type="submit">Submit Questionnaire</button>
  </form>
</section>
<style>
  .ek-form-section {
    max-width: 640px;
    margin: 2.5em auto;
    background: rgba(255,255,255,0.97);
    padding: 1.8rem 1.7rem 2.0rem 1.7rem;
    border-radius: 18px;
    box-shadow: 0 2px 14px rgba(0,0,0,0.08);
    color: #232933;
  }
  .ek-form-section label {
    margin-top: .8em;
    font-weight: 600;
    font-family: 'Marvel', Arial, sans-serif;
    color: #31445b;
    letter-spacing: .03em;
    font-size: 1.06rem;
  }
  .ek-form-section input,
  .ek-form-section select,
  .ek-form-section textarea {
    padding: 0.56em 1.1em;
    border: 1px solid #bcd6e1;
    border-radius: 9px;
    margin-bottom: 0.15em;
    background: #f9fafb;
    color: #222;
    font-size: 1.01rem;
    font-family: inherit;
    box-shadow: 0 1px 5px rgba(44,62,80,0.04);
    transition: box-shadow 0.17s;
    width: 100%;
    max-width: 100%;
  }
  .ek-form-section input:focus,
  .ek-form-section select:focus,
  .ek-form-section textarea:focus {
    outline: none;
    box-shadow: 0 0 0 2px #0693e3;
    background: #fff;
  }
  .ek-form-section textarea {
    min-height: 48px;
    max-height: 140px;
    resize: vertical;
  }
  .ek-form-section button[type="submit"] {
    margin-top: 1.35em;
    background: var(--global-palette-btn-bg-hover,#44563c);
    color: var(--global-palette-btn-hover,#fff);
    font-weight: 600;
    padding: 0.75rem 2.25rem;
    border: none;
    border-radius: 40px;
    font-size: 1.12rem;
    cursor: pointer;
    font-family: 'Marvel','Arial',sans-serif;
    box-shadow: 0px 15px 25px -7px rgba(0,0,0,0.11);
    transition: background .17s, color .17s;
    display: inline-block;
  }
  .ek-form-section button[type="submit"]:hover {
    background: var(--global-palette-btn-bg,#5e7753);
    color: #fff;
  }
  .ek-form-section .msg {
    margin-bottom: 1em;
    padding: 0.85em 1em;
    border-radius: 9px;
    font-size: 1.03em;
    background: #e2f3ea;
    color: #167c33;
    font-weight: 600;
    border: 1px solid #b3e0c7;
  }
  .ek-form-section .error {
    background: #ffeaea;
    color: #b90000;
    border: 1px solid #ffb1b1;
  }
  @media (max-width: 767px) {
    .ek-form-section { max-width: 99vw; padding: 1.1em 0.7em 1.5em 0.7em; }
  }
</style>

