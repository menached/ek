<?php
/*
Plugin Name: EK Construction Project Questionnaire
Description: Adds a custom project questionnaire form via [ek_questionnaire] shortcode. Emails results to info@devopsandplatforms.com
Version: 1.0
Author: David Menache
*/

add_shortcode('ek_questionnaire', function () {
    ob_start();
    $recipient = 'info@devopsandplatforms.com';
    $sent = false;
    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ekq_submit'])) {
        $fields = [
            'name' => sanitize_text_field($_POST['name'] ?? ''),
            'email' => sanitize_email($_POST['email'] ?? ''),
            'phone' => sanitize_text_field($_POST['phone'] ?? ''),
            'address' => sanitize_text_field($_POST['address'] ?? ''),
            'project-type' => sanitize_text_field($_POST['project-type'] ?? ''),
            'main-priority' => sanitize_text_field($_POST['main-priority'] ?? ''),
            'timeline' => sanitize_text_field($_POST['timeline'] ?? ''),
            'budget' => sanitize_text_field($_POST['budget'] ?? ''),
            'how-heard' => sanitize_text_field($_POST['how-heard'] ?? ''),
            'details' => sanitize_textarea_field($_POST['details'] ?? ''),
            'best-contact' => sanitize_text_field($_POST['best-contact'] ?? ''),
        ];

        if (!$fields['name'] || !$fields['email'] || !$fields['phone'] || !$fields['project-type'] || !$fields['main-priority']) {
            $error = 'Please fill out all required fields.';
        } elseif (!is_email($fields['email'])) {
            $error = 'Please enter a valid email address.';
        } else {
            $subject = "New Project Questionnaire from " . $fields['name'];
            $body = "A new client has submitted a project questionnaire:\n\n";
            foreach ($fields as $label => $value) {
                $body .= ucfirst(str_replace('-', ' ', $label)) . ": " . $value . "\n";
            }
            $headers = ["From: {$fields['email']}", "Reply-To: {$fields['email']}"];
            $sent = wp_mail($recipient, $subject, $body, $headers);
            if (!$sent) {
                $error = 'Sorry, there was an issue sending your message. Please try again.';
            }
        }
    }
    ?>
    <section class="ek-form-section">
      <h4>Custom Project Questionnaire</h4>
      <p>Tell us about your vision. We respond quickly to every inquiry.</p>
      <?php if ($sent): ?>
        <div class="msg">Thank you! Your questionnaire has been sent.</div>
      <?php elseif ($error): ?>
        <div class="msg error"><?php echo esc_html($error); ?></div>
      <?php endif; ?>
      <form method="POST" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">

        <label for="ekq_name">Full Name *</label>
        <input type="text" id="ekq_name" name="name" placeholder="Your full name" required value="<?php echo esc_attr($_POST['name'] ?? ''); ?>">

        <label for="ekq_email">Email *</label>
        <input type="email" id="ekq_email" name="email" placeholder="you@email.com" required value="<?php echo esc_attr($_POST['email'] ?? ''); ?>">

        <label for="ekq_phone">Phone *</label>
        <input type="tel" id="ekq_phone" name="phone" placeholder="(xxx) xxx-xxxx" required value="<?php echo esc_attr($_POST['phone'] ?? ''); ?>">

        <label for="ekq_address">Project Address (or City & ZIP)</label>
        <input type="text" id="ekq_address" name="address" placeholder="e.g. 123 Main St, City, ZIP" value="<?php echo esc_attr($_POST['address'] ?? ''); ?>">

        <label for="ekq_project_type">What type of project? *</label>
        <select id="ekq_project_type" name="project-type" required>
          <option value="">Select one</option>
          <?php $types = ['New Home Construction','Remodel / Renovation','Addition','ADU / Guest House','Kitchen Remodel','Bathroom Remodel','Outdoor Living / Deck / Pergola','Structural Repair','Other'];
    foreach ($types as $type): ?>
            <option<?php selected(@$_POST['project-type'], $type); ?>><?php echo esc_html($type); ?></option>
          <?php endforeach; ?>
        </select>

        <label for="ekq_main_priority">Main Priority *</label>
        <select id="ekq_main_priority" name="main-priority" required>
          <option value="">Select one</option>
          <?php $priorities = ['Luxury Craftsmanship','Quick Completion','Affordable Budget','Eco-Friendly / Green Build','Custom Design Features','Not Sure'];
    foreach ($priorities as $priority): ?>
            <option<?php selected(@$_POST['main-priority'], $priority); ?>><?php echo esc_html($priority); ?></option>
          <?php endforeach; ?>
        </select>

        <label for="ekq_timeline">Desired Project Timeline</label>
        <input type="text" id="ekq_timeline" name="timeline" placeholder="e.g. ASAP, Summer 2025, Flexible..." value="<?php echo esc_attr($_POST['timeline'] ?? ''); ?>">

        <label for="ekq_budget">Estimated Budget Range</label>
        <input type="text" id="ekq_budget" name="budget" placeholder="$150,000 – $300,000, not sure, etc." value="<?php echo esc_attr($_POST['budget'] ?? ''); ?>">

        <label for="ekq_how_heard">How did you hear about EK Construction?</label>
        <select id="ekq_how_heard" name="how-heard">
          <option value="">Select one</option>
          <?php $heard = ['Referral / Friend','Google','Houzz','Social Media','Repeat Client','Other'];
    foreach ($heard as $h): ?>
            <option<?php selected(@$_POST['how-heard'], $h); ?>><?php echo esc_html($h); ?></option>
          <?php endforeach; ?>
        </select>

        <label for="ekq_details">Tell us about your vision and any must-haves</label>
        <textarea id="ekq_details" name="details" rows="4" placeholder="Let us know what matters most to you in this project."><?php echo esc_textarea($_POST['details'] ?? ''); ?></textarea>

        <label for="ekq_best_contact">Best way/time to contact you</label>
        <input type="text" id="ekq_best_contact" name="best-contact" placeholder="Call, email, mornings, evenings, etc." value="<?php echo esc_attr($_POST['best-contact'] ?? ''); ?>">

        <button type="submit" name="ekq_submit">Submit Questionnaire</button>
      </form>
    </section>



    <?php
    return ob_get_clean();
});
