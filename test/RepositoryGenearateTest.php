<?php

namespace Zaman\Repo\Tests;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class RepositoryGenearateTest extends TestCase
{
    private string $contractPath = 'app/Contracts';
    private string $repositoryPath = 'app/Models/Repositories';
    private string $customPath = 'app/Interface';

    protected function setUp(): void
    {
        parent::setUp();

        // Clean up test directories if they exist
        if (File::exists($this->contractPath)) {
            File::deleteDirectory($this->contractPath);
        }
        if (File::exists($this->repositoryPath)) {
            File::deleteDirectory($this->repositoryPath);
        }
        if (File::exists($this->customPath)) {
            File::deleteDirectory($this->customPath);
        }
    }

    protected function tearDown(): void
    {
        // Clean up after tests
        if (File::exists($this->contractPath)) {
            File::deleteDirectory($this->contractPath);
        }
        if (File::exists($this->repositoryPath)) {
            File::deleteDirectory($this->repositoryPath);
        }
        if (File::exists($this->customPath)) {
            File::deleteDirectory($this->customPath);
        }

        parent::tearDown();
    }

    /** @test */
    public function it_can_generate_repository_interface_only()
    {
        // Execute command
        $this->artisan('generate:repo', ['name' => 'User'])
            ->expectsOutput('Repository created successfully!')
            ->assertExitCode(0);

        // Assert contract file exists
        $this->assertFileExists(app_path('Contracts/UserRepositoryInterface.php'));

        // Assert contract content is correct
        $contractContent = File::get(app_path('Contracts/UserRepositoryInterface.php'));
        $this->assertStringContainsString('interface UserRepositoryInterface', $contractContent);
        $this->assertStringContainsString('namespace App\Contracts', $contractContent);
    }

    /** @test */
    public function it_can_generate_interface_with_repository()
    {
        // Execute command
        $this->artisan('generate:repo', ['name' => 'User', '--m' => true])
            ->expectsOutput('Repository created successfully!')
            ->assertExitCode(0);

        // Assert all files exist
        $this->assertFileExists(app_path('Contracts/UserRepositoryInterface.php'));
        $this->assertFileExists(app_path('Models/Repositories/UserRepository.php'));

        // Check repository implementation content
        $repoContent = File::get(app_path('Models/Repositories/UserRepository.php'));
        $this->assertStringContainsString('class UserRepository implements UserRepositoryInterface', $repoContent);
        $this->assertStringContainsString('App\Models\Repositories', $repoContent);
    }

    /** @test */
    public function it_can_generate_repository_with_custom_name()
    {
        $this->artisan('generate:repo', ['name' => 'Interface/UserManagement'])
            ->expectsOutput('Repository created successfully!')
            ->assertExitCode(0);

        $this->assertFileExists(app_path('Interface/UserManagementRepositoryInterface.php'));
    }

    /** @test */
    public function it_fails_when_repository_already_exists()
    {
        // Create the repository first time
        $this->artisan('generate:repo', ['name' => 'User']);

        // Try to create it again
        $this->artisan('generate:repo', ['name' => 'User'])
            ->expectsOutput('File already exists!')
            ->assertExitCode(1);
    }

    /** @test */
    public function it_creates_repository_with_basic_crud_methods()
    {
        $this->artisan('generate:repo', ['name' => 'User', '--m' => true]);

        $interfaceContent = File::get(app_path('Contracts/UserRepositoryInterface.php'));
        $repositoryContent = File::get(app_path('Models/Repositories/UserRepository.php'));

        // Check interface methods
        $this->assertStringContainsString('public function all()', $interfaceContent);
        $this->assertStringContainsString('public function find($id)', $interfaceContent);
        $this->assertStringContainsString('public function create(array $data)', $interfaceContent);
        $this->assertStringContainsString('public function update($id, array $data)', $interfaceContent);
        $this->assertStringContainsString('public function delete($id)', $interfaceContent);

        // Check repository implementation
        $this->assertStringContainsString('public function all()', $repositoryContent);
        $this->assertStringContainsString('public function find($id)', $repositoryContent);
        $this->assertStringContainsString('public function create(array $data)', $repositoryContent);
        $this->assertStringContainsString('public function update($id, array $data)', $repositoryContent);
        $this->assertStringContainsString('public function delete($id)', $repositoryContent);
    }

    /** @test */
    public function it_validates_repository_name()
    {
        $this->artisan('generate:repo', ['name' => '123'])
            ->expectsOutput("The string contains numbers or special characters!")
            ->assertExitCode(1);

        $this->artisan('generate:repo', ['name' => 'User@Repository'])
            ->expectsOutput("The string contains numbers or special characters!")
            ->assertExitCode(1);
    }
}
