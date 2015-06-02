(
SELECT question, questionId
FROM questions
WHERE category = "Vim"
ORDER BY RAND()
LIMIT 1
)
UNION
(
SELECT question, questionId, category
FROM questions
WHERE category = "Linux"
ORDER BY RAND()
LIMIT 1
)
UNION
(
SELECT question, questionId, category
FROM questions
WHERE category = "Syntax"
ORDER BY RAND()
LIMIT 1
)

