1. Make sure you got docker downloaded

2. Replace your env file with below

```bash
MAIL_MAILER=smtp
MAIL_HOST=localhost
_MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="missdiytoken@missdiy.com"
MAIL_FROM_NAME="${APP_NAME}"
```

3. Open command prompt

```bash
docker pull mailhog/mailhog

docker run -d -p 1025:1025 -p 8025:8025 mailhog/mailhog
```

4. Receive the email from localhost:8025
