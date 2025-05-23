import sys
import json
import numpy as np
from PIL import Image

def decode_gan(image_path):
    try:
        # Load the stego image
        img = Image.open(image_path).convert('RGB')
        pixels = np.array(img)
        width, height = img.size

        # Extract binary message
        binary_message = ''
        terminator = '11111111' + '00000000'  # FF00 terminator

        for y in range(height):
            for x in range(width):
                pixel = pixels[y, x]
                # Get LSB from each RGB channel
                for color in pixel:
                    binary_message += str(color & 1)

                # Check for terminator sequence
                if len(binary_message) >= len(terminator):
                    term_index = binary_message.find(terminator)
                    if term_index != -1:
                        # Extract message before terminator
                        binary_message = binary_message[:term_index]
                        
                        # Convert binary to text (8 bits per character)
                        message = ''
                        for i in range(0, len(binary_message), 8):
                            if i + 8 <= len(binary_message):
                                byte = binary_message[i:i+8]
                                char = chr(int(byte, 2))
                                # Only add printable ASCII characters
                                if 32 <= ord(char) <= 126:
                                    message += char
                        
                        return json.dumps({
                            'success': True,
                            'message': message.strip()
                        })

        return json.dumps({
            'success': False,
            'error': 'No hidden message found'
        })

    except Exception as e:
        return json.dumps({
            'success': False,
            'error': f'Decoding failed: {str(e)}'
        })

if __name__ == '__main__':
    if len(sys.argv) != 2:
        print(json.dumps({
            'success': False,
            'error': 'Invalid arguments. Usage: script.py image_path'
        }))
        sys.exit(1)

    print(decode_gan(sys.argv[1]))