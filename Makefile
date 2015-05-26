VENDOR = ./vendor
TESTS = ./tests
test: 
	./run-test.sh tests/
test-coverage:
	./run-test.sh --coverage-html build/code-coverage tests/
