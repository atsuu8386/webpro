# Hướng dẫn chạy với Docker Compose

## Yêu cầu
- Docker
- Docker Compose

## Cách sử dụng

### 1. Khởi động container

```bash
docker-compose up -d
```

### 2. Truy cập website

Mở trình duyệt và truy cập:
```
http://localhost:8080
```

### 3. Dừng container

```bash
docker-compose down
```

### 4. Xem logs

```bash
docker-compose logs -f
```

### 5. Restart container

```bash
docker-compose restart
```

## Cấu trúc

- `html/` - Thư mục chứa các file HTML, CSS, JS, images
- `nginx.conf` - Cấu hình Nginx
- `docker-compose.yml` - Cấu hình Docker Compose

## Port

Mặc định sử dụng port **8080**. Nếu muốn đổi port, sửa trong `docker-compose.yml`:

```yaml
ports:
  - "YOUR_PORT:80"
```

## Troubleshooting

### Container không start
```bash
docker-compose logs nginx
```

### Kiểm tra container đang chạy
```bash
docker ps
```

### Rebuild container
```bash
docker-compose down
docker-compose up -d --force-recreate
```

