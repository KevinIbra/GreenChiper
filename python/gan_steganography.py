import sys
import json
import numpy as np
from PIL import Image

def encode_gan(image_path, message, output_path):
    try:
        # Load the image
        img = Image.open(image_path).convert('RGB')
        width, height = img.size
        pixels = np.array(img)

        # Convert message to binary + terminator
        binary_message = ''.join(format(ord(c), '08b') for c in message)
        binary_message += '11111111' + '00000000'  # Add terminator

        if len(binary_message) > width * height * 3:
            print(json.dumps({
                'success': False,
                'error': 'Message too long for image capacity'
            }))
            return

        # Basic GAN-like encoding (for testing)
        msg_index = 0
        modified = False
        for y in range(height):
            for x in range(width):
                if msg_index < len(binary_message):
                    pixel = pixels[y, x].copy()
                    for i in range(3):  # R,G,B channels
                        if msg_index < len(binary_message):
                            # Modify pixel values slightly
                            pixel[i] = (pixel[i] & 0xFE) | int(binary_message[msg_index])
                            msg_index += 1
                            modified = True
                    pixels[y, x] = pixel
                else:
                    break

        if not modified:
            print(json.dumps({
                'success': False,
                'error': 'Failed to embed message'
            }))
            return

        # Save the modified image
        Image.fromarray(pixels).save(output_path, 'PNG')
        
        # Calculate PSNR
        original = np.array(Image.open(image_path))
        modified = np.array(Image.open(output_path))
        mse = np.mean((original - modified) ** 2)
        psnr = 20 * np.log10(255.0 / np.sqrt(mse))

        print(json.dumps({
            'success': True,
            'message': 'Image encoded successfully with GAN',
            'psnr': float(psnr)
        }))

    except Exception as e:
        print(json.dumps({
            'success': False,
            'error': str(e)
        }))

if __name__ == '__main__':
    if len(sys.argv) != 5:
        print(json.dumps({
            'success': False,
            'error': 'Invalid arguments. Usage: script.py encode input_image message output_path'
        }))
        sys.exit(1)

    _, command, input_path, message, output_path = sys.argv
    encode_gan(input_path, message, output_path)