# Email Configuration Guide - Look Back Café

## 🚨 Current Issue: Emails Not Being Received

You're currently using **Mailtrap**, which is a **sandbox email testing service**. This means:
- ❌ Emails will **NOT** be delivered to real email addresses like `natnatsmy@gmail.com`
- ✅ All emails are **captured by Mailtrap** for testing purposes
- ✅ You can view them at [mailtrap.io](https://mailtrap.io/inboxes)

---

## 📧 Testing Current Setup

1. **Run the test script:**
   - Open your browser and go to: `http://localhost:8080/website/test_email.php`
   - This will send a test email and show you the configuration details

2. **Check Mailtrap inbox:**
   - Go to [https://mailtrap.io](https://mailtrap.io)
   - Login with your Mailtrap account
   - Check your inbox - the test email will be there!

---

## 🔧 Solutions

### Option 1: Continue Using Mailtrap (For Testing)
**Best for:** Development and testing

**Pros:**
- ✅ No risk of sending test emails to real users
- ✅ Easy to debug email templates
- ✅ Already configured

**Cons:**
- ❌ Emails don't reach real inboxes

**How to use:**
- Keep current configuration in `website/config/email.php`
- Check emails at [mailtrap.io](https://mailtrap.io/inboxes)

---

### Option 2: Use Gmail SMTP (For Real Emails) ⭐ RECOMMENDED

**Best for:** Sending real emails during development

**Setup Steps:**

1. **Enable 2-Factor Authentication on Gmail:**
   - Go to [Google Account Security](https://myaccount.google.com/security)
   - Enable 2-Step Verification

2. **Generate App Password:**
   - Go to [App Passwords](https://myaccount.google.com/apppasswords)
   - Select "Mail" and your device
   - Copy the 16-character password

3. **Update Configuration:**
   - Open `website/config/email.php`
   - Replace the content with settings from `website/config/email_gmail.php`
   - Update these values:
     ```php
     define('SMTP_USERNAME', 'your-email@gmail.com');
     define('SMTP_PASSWORD', 'your-16-char-app-password');
     define('SMTP_FROM_EMAIL', 'your-email@gmail.com');
     ```

4. **Test:**
   - Run `http://localhost:8080/website/test_email.php`
   - Check your real email inbox!

**Gmail SMTP Settings:**
```php
SMTP_HOST: smtp.gmail.com
SMTP_PORT: 587 (TLS) or 465 (SSL)
SMTP_USERNAME: your-email@gmail.com
SMTP_PASSWORD: your-app-password
```

---

### Option 3: Use SendGrid (For Production) 🚀

**Best for:** Production environment with high email volume

**Setup Steps:**

1. **Create SendGrid Account:**
   - Sign up at [sendgrid.com](https://sendgrid.com)
   - Verify your sender email

2. **Get API Key:**
   - Go to Settings > API Keys
   - Create a new API key with "Mail Send" permissions

3. **Update Configuration:**
   ```php
   define('SMTP_HOST', 'smtp.sendgrid.net');
   define('SMTP_PORT', 587);
   define('SMTP_USERNAME', 'apikey');
   define('SMTP_PASSWORD', 'your-sendgrid-api-key');
   define('SMTP_FROM_EMAIL', 'verified@yourdomain.com');
   ```

**Benefits:**
- ✅ Better deliverability
- ✅ Email analytics
- ✅ Free tier: 100 emails/day

---

## 🧪 Testing Email Functionality

### Test Script Location:
`website/test_email.php`

### What it tests:
- ✅ SMTP connection
- ✅ Email sending
- ✅ Configuration display
- ✅ Error handling

### How to run:
```
http://localhost:8080/website/test_email.php
```

---

## 📝 Quick Configuration Comparison

| Feature | Mailtrap | Gmail SMTP | SendGrid |
|---------|----------|------------|----------|
| Real emails | ❌ | ✅ | ✅ |
| Testing | ✅ | ⚠️ | ⚠️ |
| Free tier | ✅ | ✅ | ✅ (100/day) |
| Setup difficulty | Easy | Medium | Medium |
| Production ready | ❌ | ⚠️ | ✅ |
| Deliverability | N/A | Good | Excellent |

---

## 🔍 Troubleshooting

### "Email not received in Gmail"
- ✅ Check if you're using Mailtrap (emails won't reach real inboxes)
- ✅ Check spam folder
- ✅ Verify Gmail App Password is correct
- ✅ Ensure 2FA is enabled on Gmail

### "SMTP connection failed"
- ✅ Check internet connection
- ✅ Verify SMTP credentials
- ✅ Check firewall settings
- ✅ Try port 587 instead of 465 (or vice versa)

### "Authentication failed"
- ✅ Use App Password, not regular Gmail password
- ✅ Ensure FROM email matches SMTP username
- ✅ Check for typos in credentials

---

## 📞 Need Help?

1. Run the test script: `http://localhost:8080/website/test_email.php`
2. Check the detailed error messages
3. Verify your configuration matches the guide above

---

## 🎯 Recommended Setup for Your Case

Since you want to receive emails at `natnatsmy@gmail.com`:

1. **Use Gmail SMTP** (Option 2)
2. Follow the Gmail setup steps above
3. Test with `test_email.php`
4. Once working, all OTP and newsletter emails will be delivered to real inboxes!

---

**Last Updated:** 2024
**Configuration Files:**
- Current: `website/config/email.php` (Mailtrap)
- Gmail Example: `website/config/email_gmail.php`
- Test Script: `website/test_email.php`