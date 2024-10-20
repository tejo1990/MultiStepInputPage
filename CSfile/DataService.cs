using System.Net.Http;
using System.Text;
using System.Text.Json;
using Microsoft.Extensions.Configuration;

public class DataService : IDataService
{
    private readonly IConfiguration _configuration;
    private readonly HttpClient _httpClient;
    private readonly string _apiBaseUrl;

    public DataService(IConfiguration configuration, HttpClient httpClient)
    {
        _configuration = configuration;
        _httpClient = httpClient;
        _apiBaseUrl = _configuration["ApiBaseUrl"]; // appsettings.json에서 API 기본 URL을 가져옵니다.
    }

    public async Task<bool> SaveBoothDataAsync(BoothData boothData)
    {
        try
        {
            // 부스 존재 여부 확인
            var checkResponse = await _httpClient.GetAsync($"{_apiBaseUrl}/checkBooth.php?boothNumber={boothData.BoothNumber}");
            var exists = await checkResponse.Content.ReadAsStringAsync() == "exists";

            // API 엔드포인트 선택
            var endpoint = exists ? "updateDB.php" : "createDB.php";

            // JSON으로 데이터 직렬화
            var json = JsonSerializer.Serialize(boothData);
            var content = new StringContent(json, Encoding.UTF8, "application/json");

            // API 호출
            var response = await _httpClient.PostAsync($"{_apiBaseUrl}/{endpoint}", content);

            // 응답 확인
            if (response.IsSuccessStatusCode)
            {
                var result = await response.Content.ReadAsStringAsync();
                var apiResponse = JsonSerializer.Deserialize<ApiResponse>(result);
                return apiResponse.Success;
            }

            return false;
        }
        catch (Exception ex)
        {
            // 로깅 추가
            Console.WriteLine($"SaveBoothDataAsync 오류: {ex.Message}");
            return false;
        }
    }
}

public class ApiResponse
{
    public bool Success { get; set; }
    public string Error { get; set; }
}