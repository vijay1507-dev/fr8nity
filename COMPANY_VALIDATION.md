# Company Name Validation Implementation

## Overview
This implementation adds validation to ensure that company names are unique within the same country. This prevents duplicate company registrations in the same geographical location while allowing the same company name to exist in different countries.

## What Was Implemented

### 1. Custom Validation Rule
Created `app/Rules/UniqueCompanyInCountry.php` that:
- Checks if a company name already exists in the same country
- Allows the same company name in different countries
- Provides a clear error message when validation fails

### 2. Updated Controllers
Modified the following controllers to use the new validation rule:

#### AuthController (`app/Http/Controllers/Auth/AuthController.php`)
- Updated the `register` method validation rules
- Added `new UniqueCompanyInCountry` to the `company_name` field

#### MemberController (`app/Http/Controllers/MemberController.php`)
- Updated both `store` and `update` method validation rules
- Added `new UniqueCompanyInCountry` to the `company_name` field

### 3. Validation Logic
The validation rule:
1. Gets the `country_id` from the request
2. Queries the database to check if a company with the same name exists in that country
3. Fails validation if a duplicate is found
4. Passes validation if no duplicate exists or if the company name is in a different country

## How It Works

### Example Scenarios

#### Scenario 1: Same Company Name, Different Country ✅
- User A registers "ABC Company" in USA
- User B tries to register "ABC Company" in Canada
- **Result**: Validation passes (allowed)

#### Scenario 2: Same Company Name, Same Country ❌
- User A registers "ABC Company" in USA
- User B tries to register "ABC Company" in USA
- **Result**: Validation fails with error: "A company with this name already exists in the selected country."

#### Scenario 3: Different Company Names, Same Country ✅
- User A registers "ABC Company" in USA
- User B tries to register "XYZ Company" in USA
- **Result**: Validation passes (allowed)

## Error Message
When validation fails, users see:
```
A company with this name already exists in the selected country.
```

## Files Modified
1. `app/Rules/UniqueCompanyInCountry.php` - New validation rule
2. `app/Http/Controllers/Auth/AuthController.php` - Registration validation
3. `app/Http/Controllers/MemberController.php` - Member creation/update validation

## Testing
To test this validation:
1. Register a company with a specific name in one country
2. Try to register another company with the same name in the same country
3. Verify that the validation error appears
4. Try to register the same company name in a different country
5. Verify that the validation passes

## Benefits
- Prevents duplicate company registrations in the same country
- Maintains data integrity
- Allows legitimate business expansion across countries
- Provides clear user feedback
- Consistent validation across all member registration/update forms
