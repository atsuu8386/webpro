#!/bin/bash

# Script to copy resources from HTTrack downloaded folder to organized structure
# Usage: ./copy_resources.sh

# Don't use set -e, we want to handle errors manually

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Paths
HTTRACK_BASE="/mnt/d/Httrack/twelve/consulting.stylemixthemes.com/twelve"
OUTPUT_DIR="html"

echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}Copy Resources from HTTrack${NC}"
echo -e "${BLUE}========================================${NC}"
echo ""

# Check if HTTrack directory exists
if [ ! -d "$HTTRACK_BASE" ]; then
    echo -e "${RED}ERROR: HTTrack directory not found!${NC}"
    echo -e "${YELLOW}Expected path: $HTTRACK_BASE${NC}"
    echo ""
    echo "Please check if the path is correct or update HTTRACK_BASE in this script."
    exit 1
fi

# Check if index.html exists in HTTrack
if [ ! -f "$HTTRACK_BASE/index.html" ]; then
    echo -e "${RED}ERROR: index.html not found in HTTrack directory!${NC}"
    exit 1
fi

# Check if Python 3 is available - try multiple ways
PYTHON3_CMD=""
if command -v python3 &> /dev/null; then
    PYTHON3_CMD="python3"
elif command -v python &> /dev/null && python --version 2>&1 | grep -q "Python 3"; then
    PYTHON3_CMD="python"
elif [ -f /usr/bin/python3 ]; then
    PYTHON3_CMD="/usr/bin/python3"
elif [ -f /usr/local/bin/python3 ]; then
    PYTHON3_CMD="/usr/local/bin/python3"
else
    echo -e "${YELLOW}WARNING: python3 command not found in PATH${NC}"
    echo "Trying to run python3 anyway..."
    PYTHON3_CMD="python3"
fi

echo -e "${GREEN}✓ HTTrack directory found${NC}"
if [ -n "$PYTHON3_CMD" ]; then
    echo -e "${GREEN}✓ Python 3 command: $PYTHON3_CMD${NC}"
else
    echo -e "${YELLOW}⚠ Python 3 check skipped${NC}"
fi
echo ""

# Create output directories
echo "Creating output directories..."
mkdir -p "$OUTPUT_DIR/css"
mkdir -p "$OUTPUT_DIR/js"
mkdir -p "$OUTPUT_DIR/images"
mkdir -p "$OUTPUT_DIR/fonts"
mkdir -p "$OUTPUT_DIR/assets"
echo -e "${GREEN}✓ Directories created${NC}"
echo ""

# Run Python script
echo "Running Python script to copy resources..."
echo ""

# Check which script to use
if [ -f "copy_resources_from_httrack.py" ]; then
    $PYTHON3_CMD copy_resources_from_httrack.py
elif [ -f "simple_copy.py" ]; then
    $PYTHON3_CMD simple_copy.py
else
    echo -e "${RED}ERROR: Python script not found!${NC}"
    echo "Please make sure copy_resources_from_httrack.py or simple_copy.py exists."
    exit 1
fi

EXIT_CODE=$?

echo ""
if [ $EXIT_CODE -eq 0 ]; then
    echo -e "${GREEN}✓ Copy completed${NC}"
    
    # Run fix script to remove ajax requests and fix missing images
    if [ -f "fix_html.py" ]; then
        echo ""
        echo "Running fix script to remove ajax requests and fix images..."
        $PYTHON3_CMD fix_html.py
        FIX_EXIT_CODE=$?
        if [ $FIX_EXIT_CODE -eq 0 ]; then
            echo -e "${GREEN}✓ HTML fixed${NC}"
        else
            echo -e "${YELLOW}⚠ Fix script had some issues, but continuing...${NC}"
        fi
    fi
    
    echo ""
    echo -e "${BLUE}========================================${NC}"
    echo -e "${GREEN}SUCCESS! Files copied and HTML fixed.${NC}"
    echo -e "${BLUE}========================================${NC}"
    echo ""
    echo "You can now open html/index.html in your browser."
else
    echo -e "${BLUE}========================================${NC}"
    echo -e "${RED}ERROR! Check the error messages above.${NC}"
    echo -e "${BLUE}========================================${NC}"
    exit $EXIT_CODE
fi

