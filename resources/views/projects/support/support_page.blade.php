<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Support Page</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f9;
  color: #333;
  line-height: 1.6;
}

.container {
  width: 80%;
  max-width: 600px;
  margin: 50px auto;
  padding: 20px;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

h1 {
  font-size: 24px;
  margin-bottom: 20px;
  text-align: center;
}

p {
  font-size: 16px;
  text-align: center;
  margin-bottom: 20px;
}

.support-form {
  display: flex;
  flex-direction: column;
}

.support-form label {
  margin-bottom: 5px;
  font-weight: bold;
}

.support-form input, 
.support-form textarea {
  margin-bottom: 15px;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.support-form input:focus, 
.support-form textarea:focus {
  border-color: #007BFF;
  outline: none;
}

button {
  padding: 10px;
  background-color: #007BFF;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
}

button:hover {
  background-color: #0056b3;
}
  </style>
</head>
<body>

  <div class="container">
    <h1>Support Page</h1>
    <p>We're here to help! If you have any issues or questions, please fill out the form below.</p>

    <form action="#" method="POST" class="support-form">
      <label for="name">Your Name</label>
      <input type="text" id="name" name="name" placeholder="Enter your name" required>

      <label for="email">Email Address</label>
      <input type="email" id="email" name="email" placeholder="Enter your email" required>

      <label for="subject">Subject</label>
      <input type="text" id="subject" name="subject" placeholder="Enter the subject" required>

      <label for="message">Message</label>
      <textarea id="message" name="message" rows="5" placeholder="Describe your issue or question" required></textarea>

      <button type="submit">Submit</button>
    </form>
  </div>

</body>
</html>