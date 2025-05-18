import sys
import json
import numpy as np
from PIL import Image

def encode_lsb(image_path, message, output_path):
    try:
        # Load the image
        img = Image.open(image_path).convert('RGB')
        width, height = img.size
        pixels = np.array(img)

        # Convert message to binary + terminator
        binary_message = ''.join(format(ord(c), '08b') for c in message)
        binary_message += '11111111' + '00000000'  # Terminator sequence

        # Check if message can fit in image
        if len(binary_message) > width * height * 3:
            return json.dumps({
                'success': False,
                'error': 'Message too long for image capacity'
            })

        # Embed message bits
        msg_index = 0
        modified = False
        for y in range(height):
            for x in range(width):
                if msg_index < len(binary_message):
                    pixel = pixels[y, x].copy()
                    
                    # Modify RGB channels
                    for i in range(3):  # R,G,B
                        if msg_index < len(binary_message):
                            # Clear LSB and set it to message bit
                            pixel[i] = (pixel[i] & 0xFE) | int(binary_message[msg_index])
                            msg_index += 1
                            modified = True
                    
                    pixels[y, x] = pixel
                else:
                    break

        if not modified:
            return json.dumps({
                'success': False,
                'error': 'Failed to embed message'
            })

        # Save the modified image
        Image.fromarray(pixels).save(output_path, 'PNG')

        return json.dumps({
            'success': True,
            'message': 'Image encoded successfully'
        })

    except Exception as e:
        return json.dumps({
            'success': False,
            'error': str(e)
        })

def decode_lsb(image_path):
    try:
        # Load the image
        img = Image.open(image_path).convert('RGB')
        pixels = np.array(img)
        width, height = img.size

        # Extract binary message from LSB
        binary_message = ''
        for y in range(height):
            for x in range(width):
                pixel = pixels[y, x]
                # Get LSB from each RGB channel
                for color in pixel:
                    binary_message += str(color & 1)

                # Check for terminator sequence
                if len(binary_message) >= 16:
                    if binary_message[-16:-8] == '11111111' and binary_message[-8:] == '00000000':
                        # Found terminator, extract message
                        binary_message = binary_message[:-16]
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
            'error': str(e)
        })

if __name__ == '__main__':
    if len(sys.argv) < 2:
        print(json.dumps({
            'success': False,
            'error': 'No command specified'
        }))
        sys.exit(1)

    command = sys.argv[1]

    if command == 'decode':
        if len(sys.argv) != 3:
            print(json.dumps({
                'success': False,
                'error': 'Invalid arguments for decode. Usage: script.py decode image_path'
            }))
            sys.exit(1)
        print(decode_lsb(sys.argv[2]))

    elif command == 'encode':
        if len(sys.argv) != 5:
            print(json.dumps({
                'success': False,
                'error': 'Invalid arguments for encode. Usage: script.py encode input_image message output_path'
            }))
            sys.exit(1)
        print(encode_lsb(sys.argv[2], sys.argv[3], sys.argv[4]))

    else:
        print(json.dumps({
            'success': False,
            'error': f'Unknown command: {command}'
        }))
        sys.exit(1)