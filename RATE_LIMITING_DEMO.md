# Rate Limiting Demo Guide

## Overview
Your system has **working rate limiting** that blocks users after 5 failed login attempts within a 15-minute window.

## Test Results Summary ✓
- ✅ Failed login attempts are recorded in `login_attempts` table
- ✅ Rate limit triggers after 5 failed attempts
- ✅ Additional attempts are blocked when rate limited
- ✅ `rate_limit_exceeded` events are logged to `security_log`
- ✅ Time window (15 minutes) is enforced correctly

---

## Manual Testing Steps

### Step 1: Prepare Test Account
1. Use an existing email or create a test account
2. Note down the email (e.g., `test@example.com`)

### Step 2: Attempt Failed Logins
1. Go to your login page (either user or admin login)
2. Enter the test email
3. Enter an **incorrect password**
4. Click "Login"
5. **Repeat 5 times** (you should see error messages each time)

### Step 3: Verify Rate Limit Block
After the 5th failed attempt:
1. Try to login again (6th attempt)
2. You should see: **"Too many login attempts. Please try again later."**
3. This message appears even before checking the password
4. You are redirected back to the login page

### Step 4: Check Database Logs

#### Check Login Attempts Table
Run this SQL query in phpMyAdmin:
```sql
SELECT * FROM login_attempts 
WHERE identifier = 'test@example.com' 
ORDER BY attempt_time DESC 
LIMIT 10;
```

**Expected Result:**
- You should see 5 failed login attempts
- All with `success = 0`
- All within the last 15 minutes
- IP address recorded

#### Check Security Log
Run this SQL query:
```sql
SELECT * FROM security_log 
WHERE event_type = 'rate_limit_exceeded' 
ORDER BY created_at DESC 
LIMIT 10;
```

**Expected Result:**
- At least one entry with `event_type = 'rate_limit_exceeded'`
- Description mentions the email you tested
- IP address and user agent recorded
- Timestamp shows when you hit the rate limit

---

## Configuration Details

### Current Settings
- **Max Attempts:** 5 failed logins
- **Time Window:** 900 seconds (15 minutes)
- **Identifier:** Email address
- **IP Tracking:** Yes

### Where to Find Settings
File: `lookbackcafe/website/config/security.php`
Function: `check_rate_limit()`
```php
function check_rate_limit($identifier, $max_attempts = 5, $time_window = 90)
```

### To Change Settings
Edit the function call in `lookbackcafe/website/auth/login.php`:
```php
// Example: Allow 3 attempts in 10 minutes
if (check_rate_limit($email, 3, 600)) {
    // Rate limited
}
```

---

## How It Works

### 1. Login Attempt Flow
```
User submits login
    ↓
Check rate limit (check_rate_limit)
    ↓
If >= 5 attempts in 15 min → BLOCK
    ↓
Log "rate_limit_exceeded" event
    ↓
Show error message
    ↓
Redirect to login page
```

### 2. If Not Rate Limited
```
Verify credentials
    ↓
If correct → Record success + Login
    ↓
If wrong → Record failure + Show error
```

### 3. Database Recording
Every login attempt is recorded in `login_attempts`:
- `identifier`: Email address
- `ip_address`: User's IP
- `success`: 1 for success, 0 for failure
- `attempt_time`: Timestamp
- `role`: 'user' or 'admin'

### 4. Automatic Cleanup
A MySQL event runs daily to clean up old records:
```sql
DELETE FROM login_attempts 
WHERE attempt_time < DATE_SUB(NOW(), INTERVAL 7 DAY)
```

---

## Security Features

### ✓ What's Protected
1. **Brute Force Protection:** Blocks automated password guessing
2. **Account Enumeration:** Limits attempts to discover valid emails
3. **Distributed Attacks:** Tracks by email (not just IP)
4. **Audit Trail:** All attempts logged for security review

### ✓ Security Log Events
- `rate_limit_exceeded`: When user hits rate limit
- `user_login_failed`: Each failed user login
- `admin_login_failed`: Each failed admin login
- `user_login_success`: Successful user login
- `admin_login_success`: Successful admin login

---

## Testing Checklist

- [ ] Attempt 5+ failed logins with wrong password
- [ ] Verify "Too many login attempts" message appears
- [ ] Check `login_attempts` table has 5 records
- [ ] Check `security_log` has `rate_limit_exceeded` event
- [ ] Wait 15 minutes and verify you can login again
- [ ] Test with both user and admin login pages

---

## Troubleshooting

### Rate Limit Not Working?
1. Check if `login_attempts` table exists
2. Verify database connection in `config/db.php`
3. Check PHP error logs for database errors
4. Ensure `check_rate_limit()` is called before login verification

### Can't Login After Waiting?
1. Check current attempts:
   ```sql
   SELECT COUNT(*) FROM login_attempts 
   WHERE identifier = 'your@email.com' 
   AND attempt_time > DATE_SUB(NOW(), INTERVAL 15 MINUTE);
   ```
2. Manually clear attempts (for testing):
   ```sql
   DELETE FROM login_attempts WHERE identifier = 'your@email.com';
   ```

### No Security Logs?
1. Check if `security_log` table exists
2. Verify `log_security_event()` function is being called
3. Check database permissions

---

## Production Recommendations

### ✓ Already Implemented
- Rate limiting on login attempts
- Security event logging
- Automatic cleanup of old records
- IP address tracking

### Consider Adding
1. **Email Notifications:** Alert users when their account is rate limited
2. **Admin Dashboard:** View rate-limited accounts
3. **IP-Based Blocking:** Block specific IPs after repeated violations
4. **CAPTCHA:** Add CAPTCHA after 3 failed attempts
5. **Account Lockout:** Temporarily lock accounts after rate limit

---

## Sample SQL Queries for Monitoring

### Recent Failed Logins
```sql
SELECT identifier, COUNT(*) as attempts, MAX(attempt_time) as last_attempt
FROM login_attempts 
WHERE success = 0 
AND attempt_time > DATE_SUB(NOW(), INTERVAL 1 HOUR)
GROUP BY identifier
ORDER BY attempts DESC;
```

### Rate Limited Users Today
```sql
SELECT * FROM security_log 
WHERE event_type = 'rate_limit_exceeded' 
AND DATE(created_at) = CURDATE()
ORDER BY created_at DESC;
```

### Most Targeted Accounts
```sql
SELECT identifier, COUNT(*) as total_attempts
FROM login_attempts 
WHERE success = 0
AND attempt_time > DATE_SUB(NOW(), INTERVAL 7 DAY)
GROUP BY identifier
ORDER BY total_attempts DESC
LIMIT 10;
```

---

## Conclusion

✅ **Your rate limiting system is fully functional and working correctly!**

The automated test confirmed all features are working as expected. You can now demonstrate this to stakeholders or use it as part of your security documentation.