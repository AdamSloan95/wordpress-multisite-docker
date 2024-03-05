# Check if mkcert is installed
if ! command -v mkcert &> /dev/null; then
    echo "Error: mkcert is not installed. Please install mkcert first."
    exit 1
fi

# Check if certs directory already exists
if [ -d "certs" ]; then
    echo "Certificates directory already exists."
else
# Create certs directory if not exists
    mkdir -p certs
fi

# Generate SSL certificates using mkcert
mkcert -install
mkcert -cert-file ./certs/localhost.test.pem -key-file ./certs/localhost.test-key.pem localhost.test site1.localhost.test site2.localhost.test site3.localhost.test