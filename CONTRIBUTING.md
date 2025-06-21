# Contributing to Laravel Country Code

Thank you for your interest in contributing to the Laravel Country Code package! This document provides guidelines and information for contributors.

## Table of Contents

- [Code of Conduct](#code-of-conduct)
- [How Can I Contribute?](#how-can-i-contribute)
- [Development Setup](#development-setup)
- [Coding Standards](#coding-standards)
- [Testing](#testing)
- [Submitting Changes](#submitting-changes)
- [Reporting Bugs](#reporting-bugs)
- [Feature Requests](#feature-requests)

## Code of Conduct

This project and everyone participating in it is governed by our Code of Conduct. By participating, you are expected to uphold this code.

## How Can I Contribute?

### Reporting Bugs

- Use the GitHub issue tracker
- Include detailed steps to reproduce the bug
- Provide your PHP version, Laravel version, and package version
- Include any error messages or stack traces

### Suggesting Enhancements

- Use the GitHub issue tracker
- Describe the enhancement clearly
- Explain why this enhancement would be useful
- Provide examples of how it would work

### Pull Requests

- Fork the repository
- Create a feature branch (`git checkout -b feature/amazing-feature`)
- Make your changes
- Add tests for new functionality
- Ensure all tests pass
- Update documentation if needed
- Submit a pull request

## Development Setup

1. Fork and clone the repository:
```bash
git clone https://github.com/your-username/laravel-country-code.git
cd laravel-country-code
```

2. Install dependencies:
```bash
composer install
```

3. Set up testing environment:
```bash
cp phpunit.xml.dist phpunit.xml
```

4. Run tests:
```bash
composer test
```

## Coding Standards

- Follow PSR-12 coding standards
- Use type hints and return types (PHP 8.2+)
- Write meaningful commit messages
- Add PHPDoc comments for public methods
- Use Laravel conventions for naming and structure

## Testing

### Running Tests

```bash
# Run all tests
composer test

# Run tests with coverage
composer test -- --coverage

# Run specific test file
composer test -- tests/Feature/CountryCodeTest.php
```

### Writing Tests

- Write tests for all new functionality
- Use descriptive test method names
- Test both success and failure scenarios
- Mock external dependencies when appropriate
- Use database transactions for database tests

### Test Structure

```php
/** @test */
public function it_can_perform_specific_action()
{
    // Arrange
    $data = [...];
    
    // Act
    $result = $this->service->performAction($data);
    
    // Assert
    $this->assertNotNull($result);
    $this->assertEquals($expected, $result);
}
```

## Submitting Changes

1. **Create a feature branch** from the main branch
2. **Make your changes** following the coding standards
3. **Write tests** for new functionality
4. **Update documentation** if needed
5. **Run tests** to ensure everything works
6. **Commit your changes** with a clear message
7. **Push to your fork** and create a pull request

### Commit Message Format

```
type(scope): description

[optional body]

[optional footer]
```

Examples:
- `feat(api): add country validation endpoint`
- `fix(model): correct phone code formatting`
- `docs(readme): update installation instructions`

### Pull Request Guidelines

- Provide a clear description of the changes
- Include any relevant issue numbers
- Add screenshots for UI changes
- Ensure all CI checks pass
- Request reviews from maintainers

## Reporting Bugs

### Before Submitting

1. Check if the bug has already been reported
2. Try to reproduce the bug with the latest version
3. Check if the bug is related to your environment

### Bug Report Template

```markdown
**Bug Description**
A clear description of what the bug is.

**Steps to Reproduce**
1. Go to '...'
2. Click on '....'
3. Scroll down to '....'
4. See error

**Expected Behavior**
What you expected to happen.

**Actual Behavior**
What actually happened.

**Environment**
- PHP Version: [e.g., 8.2.0]
- Laravel Version: [e.g., 11.0]
- Package Version: [e.g., 1.0.0]
- Database: [e.g., MySQL 8.0]

**Additional Context**
Any other context about the problem.
```

## Feature Requests

### Before Submitting

1. Check if the feature has already been requested
2. Consider if the feature fits the package's scope
3. Think about the implementation approach

### Feature Request Template

```markdown
**Feature Description**
A clear description of the feature you'd like to see.

**Use Case**
Why this feature would be useful and how it would be used.

**Proposed Implementation**
Any ideas you have about how this could be implemented.

**Alternatives Considered**
Any alternative solutions you've considered.

**Additional Context**
Any other context about the feature request.
```

## Code Review Process

1. All pull requests require at least one review
2. Maintainers will review for:
   - Code quality and standards
   - Test coverage
   - Documentation updates
   - Security considerations
3. Address any feedback before merging

## Release Process

1. Update version numbers in `composer.json`
2. Update CHANGELOG.md with new features/fixes
3. Create a release tag
4. Publish to Packagist

## Questions?

If you have questions about contributing, please:

1. Check the existing documentation
2. Search existing issues
3. Create a new issue for general questions

Thank you for contributing to Laravel Country Code! 