# Input Handling

## Overview
The Input library provides a secure way to handle POST and GET data with automatic sanitization.

## Usage

### Getting POST Data
```php
// Get single POST value
$name = $this->input->post('name');

// Get POST value with default
$age = $this->input->post('age', '0');

// Get all POST data
$allPost = $this->input->post();
```

### Getting GET Data
```php
// Get single GET value
$id = $this->input->get('id');

// Get GET value with default
$page = $this->input->get('page', '1');

// Get all GET data
$allGet = $this->input->get();
```

## Security Features
- Automatic HTML entity encoding
- SQL injection prevention
- Whitespace trimming
- Array sanitization support
- XSS protection

## Example Usage
```php
public function add() {
    $data = [
        'kode' => $this->input->post('kode'),
        'item' => $this->input->post('item'),
        'harga' => $this->input->post('harga')
    ];
}
``` 