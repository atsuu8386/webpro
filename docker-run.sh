#!/bin/bash

# Docker management script for webpro project
# Usage: ./docker-run.sh [start|stop|restart|logs|status]

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

ACTION=${1:-start}

case $ACTION in
    start)
        echo -e "${BLUE}Starting Docker containers...${NC}"
        docker compose up -d
        if [ $? -eq 0 ]; then
            echo -e "${GREEN}✓ Containers started successfully!${NC}"
            echo -e "${BLUE}Website available at: http://localhost:8080${NC}"
        else
            echo -e "${RED}✗ Failed to start containers${NC}"
            exit 1
        fi
        ;;
    stop)
        echo -e "${BLUE}Stopping Docker containers...${NC}"
        docker compose down
        if [ $? -eq 0 ]; then
            echo -e "${GREEN}✓ Containers stopped${NC}"
        else
            echo -e "${RED}✗ Failed to stop containers${NC}"
            exit 1
        fi
        ;;
    restart)
        echo -e "${BLUE}Restarting Docker containers...${NC}"
        docker compose restart
        if [ $? -eq 0 ]; then
            echo -e "${GREEN}✓ Containers restarted${NC}"
            echo -e "${BLUE}Website available at: http://localhost:8080${NC}"
        else
            echo -e "${RED}✗ Failed to restart containers${NC}"
            exit 1
        fi
        ;;
    logs)
        echo -e "${BLUE}Showing container logs...${NC}"
        docker compose logs -f
        ;;
    status)
        echo -e "${BLUE}Container status:${NC}"
        docker compose ps
        ;;
    *)
        echo "Usage: $0 {start|stop|restart|logs|status}"
        echo ""
        echo "Commands:"
        echo "  start   - Start the containers"
        echo "  stop    - Stop the containers"
        echo "  restart - Restart the containers"
        echo "  logs    - Show container logs"
        echo "  status  - Show container status"
        exit 1
        ;;
esac

