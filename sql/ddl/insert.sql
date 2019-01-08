USE `travel`;


INSERT INTO `User`
    (`email`, `name`, `password`)
    VALUES
        ("test@test.com", "Admin", "$2y$10$WZ9Htf2X5yGqXGVP5rwtRO7/rJNjpT3J9g./G/fttVtPIuHFQgjnW"),
        ("123@test.com", "Eric", "$2y$10$WZ9Htf2X5yGqXGVP5rwtRO7/rJNjpT3J9g./G/fttVtPIuHFQgjnW");

INSERT INTO `Question` (`title`, `question`, `user`, `slug`, `created`)
    VALUES
        ("What to do in Japan?", "I'm travelling to Tokyo, Japan in April and don't know what to do!
 
 Please help me!
 
 /Eric", "2", "what-to-do-in-japan", NOW()),
        ("Best country", "What is the best country to travel to in the world?", "2", "best-country", NOW()),
        ("test", "Test", "1", "test-1", NOW()),
        ("test", "Test", "1", "test-2", NOW()),
        ("test", "Test", "1", "test-3", NOW());

INSERT INTO `Answer`
    (`answer`, `user`, `question`, `created`)
    VALUES
        ("Go to Tokyo!", "1", "1", NOW()),
        ("Europe is fun!", "1", "2", NOW());

INSERT INTO `Tag`
    (`tag`, `slug`, `question`)
    VALUES
        ("Japan", "japan", "1"),
        ("Tokyo", "tokyo", "1"),
        ("World", "world", "2"),
        ("Travel", "travel", "2");

INSERT INTO `Comment`
    (`text`, `user`, `type`, `post`, `created`)
    VALUES
        ("Europe is not a country", "2", "answer", "2", NOW()),
        ("Yes it is!", "1", "answer", "2", NOW()),
        ("Lol", "2", "question", "1", NOW());
