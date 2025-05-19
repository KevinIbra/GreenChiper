# GreenChiper - Image Steganography Web Application

GreenChiper is a web application that allows users to hide secret messages within images using various steganography techniques. The application provides multiple encoding methods and a user-friendly interface for secure message hiding and extraction.

## Features

- **Multiple Steganography Methods:**
  - LSB (Least Significant Bit)
  - GAN (Generative Adversarial Network)
  - Autoencoder

- **Key Functionalities:**
  - Message encoding in images
  - Message extraction from stego images
  - Download encoded images
  - Visual quality metrics (PSNR, SSIM)
  - Support for JPEG and PNG formats

## Installation

1. **Clone the repository:**
```bash
git clone https://github.com/KevinIbra/GreenChiper.git
cd Green
```

2. **Install PHP dependencies:**
```bash
composer install
```

3. **Install Python dependencies:**
```bash
pip install pillow numpy torch torchvision
```

4. **Set up environment:**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Create storage link:**
```bash
php artisan storage:link
```

## Usage

1. **Encoding a Message:**
   - Upload an image
   - Enter your secret message
   - Select encoding method
   - Click "Encode Image"
   - Download the resulting stego image

2. **Decoding a Message:**
   - Upload a stego image
   - Select the correct decoding method
   - Click "Decode Message"
   - View the extracted message

## Security Features

- MIME type validation
- File size limitations
- Path traversal protection
- CSRF protection
- Secure file handling

## Requirements

- PHP >= 8.1
- Python >= 3.8
- Composer
- Node.js & NPM
- Web server (Apache/Nginx)
- PIL, NumPy, PyTorch libraries

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgments

- Laravel Framework
- PyTorch
- NumPy
- Pillow
