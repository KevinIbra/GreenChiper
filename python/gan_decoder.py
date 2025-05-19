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
        terminator = '1111111100000000'  # 8 ones followed by 8 zeros
        
        for y in range(height):
            for x in range(width):
                pixel = pixels[y, x]
                # Get LSB from each channel
                for color in pixel:
                    binary_message += str(color & 1)
                    
                # Check for terminator sequence
                if len(binary_message) >= len(terminator):
                    if binary_message[-len(terminator):] == terminator:
                        # Found terminator, extract actual message
                        binary_message = binary_message[:-len(terminator)]
                        # Convert binary to text
                        message = ''
                        for i in range(0, len(binary_message), 8):
                            if i + 8 <= len(binary_message):
                                byte = binary_message[i:i+8]
                                message += chr(int(byte, 2))
                        return json.dumps({
                            'success': True,
                            'message': message
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